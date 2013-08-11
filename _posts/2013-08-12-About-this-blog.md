---
layout: post
title: Tech behind this blog
categories: Technology
tags: Jekyll, GitHub
---

A while ago I decided to add a blog to my personal website. I think it would be a good place to share my technical notes, and even some little things about my boring geek life.

I used to set up a blog system before, using PhD+MySQL. This was too clumsy, let embrace minimalism!

A few requirements:
* Lightweight - I am a lazy blogger, there won't be many posts.
* Portable - Minimal effort to bring the stuff around. Remember MySpace and Xanga?
* Easy - I just need to jot down some codes, write a few lines. Don't increase my burden of coding...

After a few trials, I found `Jekyll` quite enjoyable. Neither database nor coding is necessary. I just need to write my post in plain text. If I use a lightweight markup language called `Markdown` (?!), I can even produce some decent pages.

John Gruber, the creator of Markdown says:

> Markdown is a text-to-HTML conversion tool for web writers. Markdown allows you to write using an easy-to-read, easy-to-write plain text format, then convert it to structurally valid XHTML (or HTML).

Moreover, Jekyll is the engine behind GitHub pages, which means I can host my blog on GitHub! Nice :)

So, here we go. Just two steps
1. Set up a repository on GitHub, name it USERNAME.github.com
2. Install Jekyll-Bootstrap
	```
	git clone https://github.com/plusjade/jekyll-bootstrap.git USERNAME.github.com
	cd USERNAME.github.com
	git remote set-url origin git@github.com:USERNAME/USERNAME.github.com.git
	git push origin master
	```

To write a new post:
1. Create a text file under directory `_posts`, name it in the following format
	```year-month-date-title.md```
2. Include a YAML front matter block which tells Jekyll that it is a special file. [Details](http://jekyllrb.com/docs/frontmatter/)
	```
	---
	layout: post
	title: Blogging Like a Hacker
	---
	```
3. Type in plaintext, or enhance it using `Markdown`. [Details](http://daringfireball.net/projects/markdown/syntax#link)
4. Publish your work!
	```
	git add .
	git commit -m "Add new content"
	git push origin master
	```
5. Go to USERNAME.github.com and see the results.

If you want to see your site locally, install Jekyll (prerequisite: Ruby and Ruby Gems installed)
	```
	gem install jekyll
	cd USERNAME.github.com
	jekyll serve
	```

Browse to http://localhost:4000

Useful links:

[Jekyll quick start](http://jekyllbootstrap.com/usage/jekyll-quick-start.html)

[Jekyll](http://jekyllrb.com/)

[Markdown](http://daringfireball.net/projects/markdown/)

