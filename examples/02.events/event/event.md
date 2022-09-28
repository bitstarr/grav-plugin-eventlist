---
title: Event Details
redirect: /theatre/events
flex:
  router: events

form:
  name: form
  action: "#form"
  scope: ''
  classes: 'modular form'
  fields:
    - name: name
      id: field-name
      label: PLUGIN_EVENTLIST.FORM.NAME
      placeholder: PLUGIN_EVENTLIST.FORM.NAME_PH
      autocomplete: on
      type: text
      outerclasses: levitate
      validate:
        required: true

    - name: email
      id: field-email
      label: PLUGIN_EVENTLIST.FORM.EMAIL
      placeholder: PLUGIN_EVENTLIST.FORM.EMAIL_PH
      type: email
      outerclasses: levitate
      validate:
        required: true

    - name: text
      id: field-text
      label: PLUGIN_EVENTLIST.FORM.SIGNIN_MESSAGE
      placeholder: PLUGIN_EVENTLIST.FORM.SIGNIN_MESSAGE_PH
      type: textarea
      outerclasses: levitate
      rows: 4
      validate:
        required: true

    - name: personality
      id: field-personality
      outerclasses: text-input
      label: PLUGIN_EVENTLIST.FORM.SPAM_Q
      type: radio
      options:
        meuller: Müller
        einstein: Einstein
        rossi: Rossi
      validate:
        required: true
        pattern: "^einstein$"
        message: PLUGIN_EVENTLIST.FORM.SPAM_FAIL

    - name: dsgvo
      id: field-dsgvo
      label: PLUGIN_EVENTLIST.FORM.DSGVO
      type: checkbox
      markdown: true
      validate:
        required: true

    - name: event
      type: hidden
      value: event.title
      evaluate: true

    - name: date
      type: hidden
      value: event.start|date('d.m.Y')
      evaluate: true

  buttons:
    - type: submit
      value: PLUGIN_EVENTLIST.FORM.SUBMIT

  process:
    matchmail: true
    email:
      from: "{{ config.plugins.email.from }}"
      from_name: "{{ form.value.name }}"
      to: "{{ config.plugins.email.to }}"
      reply_to: "{{ form.value.email }}"
      subject: "Anmeldung via Termin-Formular"
      body: "{% include 'email/event.txt.twig' %}"
      content_type: 'text/plain'
    # save:
    #   fileprefix: contact-
    #   dateformat: Ymd-His-u
    #   extension: txt
    #   body: "{% include 'email/contact.txt.twig' %}"
    message: PLUGIN_EVENTLIST.FORM.THANKS
    reset: true
---