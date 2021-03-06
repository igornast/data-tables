igornast/data-tables
================
DataTables Symfony component provide easy to use tool that allow you to build dynamically 
generated js tables for your doctrine entities. Feel free to send feedback 
and suggestions about development and features implementation.

Primary goal is to improve rendering viewstwig  with listings, 
to make them more friendly to users and Symfony developers.

### Example

<p align="center">
  <img width="480" height="auto" src="https://media.giphy.com/media/LnVtbUzSP1syuLZAFA/giphy.gif">
</p>

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

### Usage

Data-tables can be used to create listings loaded by AJAX request. Additionally rows can be filtered, 
sorted and paginated. 
Script will send POST request to package controller which will return JSON reponse on success.
```
igornast_datatables_get_data POST  /igornast-data-tables/get-data
```

### Scripts

Add and install assets (js, css) into your base twig template, use twig extension to render listing.
```twig
{% block body %}
    <script src="{{ asset('bundles/igornastdatatables/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bundles/igornastdatatables/js/datatables.min.js') }}"  type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('bundles/igornastdatatables/css/datatables.css') }}">

    {{ igornast_listing(listing) }}
{% endblock %}
```

### Build Listing

Use ListingManager service to build listing instance 
```php
$listing = $listingManager
        ->createListingBuilder('my_awesome_table', SampleItem::class)
        ->getListing();
```

Pass table name and entity FQN.
Data will be loaded from given entity and property from 'mainSearchField' will be used during rows filtration.

```php
class IndexController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(ListingManager $listingManager)
    {
        $listing = $listingManager
            ->createListingBuilder('my_awesome_table', SampleItem::class)
            ->mainSearchField('name')
            ->template('custom_listing_template.html.twig')
            ->column('id', 'Object Id')
            ->column('type', 'Type')
            ->column('name', 'Name')
            ->getListing();

        return $this->render('index.html.twig', ['listing' => $listing]);
    }
}
```
Add columns by passing property name and column label to ListingBuilder::column method.
Component currently support only scalar values;
```php
$listing->column('entityProperty', 'Column Label');
```
Pass custom template with ListingBuilder::template method.
```php
$listing->template('listing_template.html.twig');
```

## License
   
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details