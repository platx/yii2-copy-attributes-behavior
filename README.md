Yii 2 Copy Attributes Behavior
==============================
Copies values to attributes from other attributes

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist platx/yii2-copy-attributes-behavior "*"
```

or add

```
"platx/yii2-copy-attributes-behavior": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your ActiveRecord by  :

```php
public function behaviors()
{
    return [
        'copy-attributes' => [
            'class' => '\platx\copyattributes\CopyAttributesBehavior',
            'clearTags' => true,
            'maxLength' => 160,
            'attributes' => [
                'share_title' => 'name',
                'share_content' => 'content_short',
            ],
        ]
    ];
}
```

Behavior configuration
-----

- `clearTags`: _boolean_, It determines whether to clear the attribute of html tags. Defaults to `false`.
- `maxLength`: _integer_, Trim the text to the specified length. Defaults to `false`.
- `attributes`: _array_, Array of attributes ( target attribute => source attribute). Defaults to `null`:

```php
'attributes' => [
    'target_attribute' => 'source_attribute',
    'target_attribute2' => 'source_attribute2',
    ...
],
```
