# SLUB Forms

This is another form extension used at the Saxony State and University Library (SLUB) in Dresden, Germany.
It has been developed in 2013 with target version TYPO3 4.5 and is still maintained.

## Features

All forms are single-steps forms.

Prefill fields via GET-parameters.

Form validation in JavaScript and server-side.

Highly configurable by editors.

## Form selection

To use frontend form selection, there should be four parent forms which act as parent category. This forms have to be selected in the frontend plugin.

```
form 1, shortname="anregung-kritik"
  |-- from 10
  |-- from 11
form 2, shortname="sammlungen-bestaende"
  |-- from 20
  |-- from 21
form 3, shortname="service"
  |-- from 30
  |-- from 31
form 4, shortname="wissenschaftliches-arbeiten"
  |-- from 40
  |-- from 41
```

## Known Issues

To validate file mime-types server-side the tool file must be installed.
