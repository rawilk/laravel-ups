---
title: Usage
sort: 1
---

## Entities

Most of the classes you will interact with in this package are an `Entity`, which is a class that behaves very similar to
Eloquent's Model classes. All the attributes on an Entity are snake case, e.g. `country_code`, and you can set them 
either through the constructor as an array, or directly on an entity instance.

```php
use Rawilk\Ups\Entity\Address\Address;

$address = new Address([
    'city' => 'Some city',
]);

$address->city; // 'Some city'
$address->state; // null

// Now we can set the "state" attribute after we have created a new instance
$address->state = 'Some state';

$address->state; // 'Some state'
```

The entities were created this way to allow flexibility when creating the objects needed to send through
the UPS api. Since the UPS api requires XML, the entities will take whatever attributes they have set on them
and convert them to the proper XML tag names behind-the-scenes for you. Any entities that are created as
a result from an XML response received from the API will have their attributes filled and mapped out
correctly for you.

Although there are already many entities available to use for both requests and responses, there are many
more that could be created and used in your requests. There are also many attributes that have not been
added, or at least documented in the class doc blocks, that could be there as well. If I would have taken
the time to try and add all of them AND write tests for them, I never would have finished this package. If
you need some other entity or attribute that isn't available, feel free to fork the package and create
a new pull request with the new entities/attributes.

## API Usage

Granted you have necessary credentials, the APIs are free to use through UPS for the most part. One exception is 
any shipments you create through the API you will of course have to pay for.

The APIs this package uses have many possible data points that can both be sent and received through the API. This
package is meant to handle some of the most common use cases of each api, but of course it won't handle everything
out of the box. Like with the Entities, feel free to create pull requests for any missing features and/or
bugs you happen to find in the package.

Like with any API, you should read over the documentation provided by UPS first so you have an understanding
of how each of the apis work and how to use them. 
