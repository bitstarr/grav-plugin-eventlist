# Eventlist Plugin

The **Eventlist** Plugin is an extension for [Grav CMS](http://github.com/getgrav/grav).

! Warning: This plugin targets theme developers. There are no CSS styles included, because it's meant to get custom templates and styles.

## About

This plugin provides a Flex Directory for events and templates to show a simple list of forthcoming events. Events canf be setup to have a details page with more information, an image gallery, downloads or a registration form.

## Setup

After [Installation](#installation) the Flex Directory is automatically active and you will find the category Events in the admin interface.

### Pages

To show the listing in frontend you need to create a page [`events.md`](examples/02.events/events.md). If you want to use the details page for events, you will need to create an [`event.md`](examples/02.events/event/event.md) child page for the list page. That way you achive URLS like `DOMAIN/theatre/events` and `DOMAIN/theatre/events/event/ce1ece47f59802de4ce0772f8af5a82f`.

```
.
├── /01.home
│   …
│   ├── /04._events
│   │   └── events.md
│   …
├── /02.theatre
│   ├── /01.location
│   └── /02.events
│       ├── /event
│       │   └── event.md
│       └── events.md
├── /03.catering
```

! Note that the page folder for the event list could also be on the first hierarchical level. It's only important, that the namin of the page files is correct.

There are two important lines for the event details page frontmatter:

```
redirect: /theatre/events   # where to send users, if the URL is invalid
flex:
  router: events            # this triggers the processing for the details page
```

The redirect will be called, if a details URL is invalid. This happend if an event get unpublished or the details are disabled.

The included template for the [event list](templates/events.html.twig) is very simple whereas the template for the [details page](templates/event.html.twig) is pretty extensive and opinionated torwards my own [boilerplate/framework theme](https://github.com/bitstarr/grav-theme-chassis). The partial for the gallery is overly specific to my needs, so you will need to customize this for the way your theme can handle this.

To avoid writing static routes in config files, the path to the event details page will be the first child page of the page the list is rendered inside. To show event lists in other places, take guidance by the [widget template](templates/flex/events/collection/widget.html.twig).

! This plugin provides translations, also for the form that is included in the page examples. Make sure to customize if the field don't match you requirements.

### Modular

Often times you will need to preview events on a home page. I usually build home pages as modular page. This plugin includes an [events modular](templates/modular/events.html.twig).

In the [frontmatter of the modular](examples/01.home/04._events/events.md), you will need to note the path to the list page to show a link.

---

## Installation

This Plugin will not be published via GPM because it's meant to be a building block of your custom theme. It **can not** run out of the box, bbecause you will have to use custom templates, CSS and JS (see above).

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `eventlist`. You can find these files on [GitHub](https://github.com/bitstarr/grav-plugin-eventlist) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/eventlist

> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com/bitstarr/grav-plugin-eventlist/blob/master/blueprints.yaml).


## Configuration

Before configuring this plugin, you should copy the `user/plugins/eventlist/eventlist.yaml` to `user/config/plugins/eventlist.yaml` and only edit that copy.

Here's a look at the default settings:

```yaml
enabled: true
```

Note that if you use the Admin Plugin, a file with your configuration named eventlist.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.


