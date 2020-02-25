igornast/data-tables
================
DataTables Symfony component provide easy to use tool that allow you to build dynamically 
generated js tables for your doctrine entities. MVP version available, feel free to send feedback 
and suggestions about development and features implementation.

Primary goal is to improve rendering twig views with listings, 
to make them more friendly to users and Symfony developers.

### Installation

Install component with Composer.
```
composer require igornast/data-tables
```
Enable bundle in bundles.php array.
```php
return [
    //others
    Igornast\DataTables\IgornastDataTablesBundle::class => ['all' => true],
];
```

###Usage

Data-tables can be used to create listings loaded by AJAX request. Additionally rows can be filtered, 
sorted and paginated. 
Script will send POST request to package controller which will return JSON reponse on success.
```
igornast_datatables_get_data POST  /igornast-data-tables/get-data
```

###Scripts

Add and install assets (js, css) into your base twig template, use twig extension to render listing.
```twig
{% block body %}
    <script src="{{ asset('bundles/igornastdatatables/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bundles/igornastdatatables/js/datatables.min.js') }}"  type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('bundles/igornastdatatables/css/datatables.css') }}">

    {{ igornast_listing(listing) }}
{% endblock %}
```

###Build Listing

Extend Controller class with AbstractDataTablesController or create new instance for personal use.
```php
$first = (new ListingBuilder('my_awesome_table', 'app_index'));
$second = $this->createListingBuilder('my_awesome_table_name', 'app_index');
```
Pass table name and route name of the controller that will render this specific listing table.
Route name is used to identify controller action and read configuration defined in annotation.
Data will be loaded from given entity and property from 'searchField' will be used during rows filtration.

```php
class IndexController extends AbstractDataTablesController
{
    /**
     * @Route("/", name="app_index")
     * @DataTables(entity="App\Entity\SampleItem", searchField="name")
     */
    public function index()
    {
        $listing = $this
            ->createListingBuilder('my_awesome_table_name', 'app_index')
            ->addColumn('id', 'Id')
            ->addColumn('name', 'Name')
            ->addColumn('type', 'Type');

        return $this->render('index.html.twig', ['listing' => $listing]);
    }
}
```
Add columns by passing property name and column label to ListingBuilder::addColumn method.
Component currently support only scalar values;
```php
$listing->addColumn('entityProperty', 'Column Label');
```

###Annotation

Use data-tables component annotations to configure entity and search field for listing.

```php
    /**
     * @DataTables(entity="App\Entity\SampleItem", searchField="name")
     */
    public function index()
    {
        //listing builder code

        return $this->render('index.html.twig', ['listing' => $listing]);
    }
```

## License
   
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details