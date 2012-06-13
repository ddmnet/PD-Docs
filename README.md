# About PD's Docs

I wanted a really simple list of documents I'm currently working on in Markdown,
and I wanted a way to have them parsed, and I wanted a way to share them with somebody.

So I built PD's Docs.  It's a super-basic websitey thing that lists all the .md docs in
a directory, and links them up to get rendered.

There's a couple config variables right up top that you can modify to customize.

This is use-as-you-like; it's not super robust and it's probably extremely fragile.  It
works for me, try it out.  Pull requests welcome.

## Using

Pretty simple.

 1. Pull down this repo.
 2. Point MAMP (or your PHP runnin' Apache) at the root of your checked out repo.
 3. Add a Markdown doc (filename formatted *.md) into the docs directory.
 4. Have a look.

## Requires

Apache + PHP.  I'm sure you could use this with Nginx or something, but you'd have to
emulate what's happening in the `.htaccess` file to get the pretty URLs.

## Credits

Of course, I just made the glue.  The heavy lifting is from two very fine projects:

 * [Twitter Bootstrap](http://twitter.github.com/bootstrap/)
 * [PHP Markdown Extra](http://michelf.com/projects/php-markdown/extra/)