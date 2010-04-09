# PHP HTML Writer

Create HTML tags and render them efficiently.

## Overview

    $view->tag('div', 'some content') // <div>some content</div>
    $view->tag('div#my_id.my_class') // <div id="my_id" class="my_class"></div>
    $view->tag('a.my_class title="Social Coding"', 'GitHub') // <a class="my_class" title="Social Coding">GitHub</a>

## Why you should use it

 - it always generate valid HTML and XHTML code
 - it makes templates cleaner
 - it's easy to use, fast to execute, fully tested and documented

## Usage

### Instanciate a view instance

    $view = new phpHtmlWriter();

### Render tags

#### Simple tags

Use the ->tag() method to create a tag element.
The first argument is the HTML tag name, like div or span.
The second argument is the tag content.

    $view->tag('div')
    <div></div>

    $view->tag('p', 'some content')
    <p>some content</p>

#### CSS expressions

The first argument accepts CSS expressions.
It allows to specify very quickly the tag id and classes

    $view->tag('div#my_id')
    <div id="my_id"></div>

    $view->tag('div.my_class')
    <div class="my_class"></div>

    $view->tag('div#my_id.my_class.another_class')
    <div id="my_id" class="my_class another class"></div>

#### Inline attributes

The first argument also accepts inline attributes.
It allows to specify every HTML attribute like href or title.

    $view->tag('a href="http://github.com"')
    <a href="http://github.com"></a>

    $view->tag('a rel=nofollow href="http://github.com" title="Social Coding"')
    <a rel="nofollow" href="http://github.com" title="Social Coding"></a>

    $view->tag('span lang=es', 'Vamos a la playa, señor zorro')
    <span lang="es">Vamos a la playa, señor zorro</span>

You can use both CSS expressions and inline attributes:

    $view->tag('a#my_id.my_class.another_class href="http://github.com"', 'Github');
    <a id="my_id" class="my_class another class" href="http://github.com">Github</a>

#### Array attributes

If you prefer, you can pass HTML attributes like href and title with an array.
Pass the attributes array as the second argument, and the tag content as the third argument

    $view->tag('a', array('href'=>'http://github.com'), 'GitHub');
    <a href="http://github.com">GitHub</a>

You can use both CSS expressions, inline expressions and array attributes

    $view->tag('a#my_id.my_class rel=nofollow', array('href'=>'http://github.com'), 'GitHub');
    <a id="my_id" class="my_class another class" rel="nofollow" href="http://github.com">GitHub</a>