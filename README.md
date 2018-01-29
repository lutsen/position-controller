[<img src="https://cdn.rawgit.com/lutsen/lagan/master/lagan-logo.svg" width="100" alt="Lagan">](https://github.com/lutsen/lagan)

Lagan Position Property Controller
==================================

Controller for the Lagan Position property.

Makes room for the newly positioned Redbean bean by updating the positions of other beans, and returns the new position of the bean.

To be used with [Lagan](https://github.com/lutsen/lagan). Lagan lets you create flexible content objects with a simple class, and manage them with a web interface.

The position property as an optional *manytoone* key in the property array. With this key, you can set the position relative to the opject the current object has a many-to-one relation with, like this: `'manytoone' => 'page'`

Lagan is a project of [Lútsen Stellingwerff](http://lutsen.net/).