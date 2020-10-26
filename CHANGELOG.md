# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Open]

### To Add

* add a command to add a holiday periode (with start and end date)
    * the command is calculating the amount of calendar weeks to produce
    * for each day, their has to be a record like the following
    ```
_YYMMDD

08:00   <   holiday
    ```
* add output of "work done today"
    * either updated on each interaction or each 15 minutes
    * think about playing with colors (yellow or orange if over configured daily amount of work, red if overdone by 20 % or something)
* add option to set a "subject prefix"
* add option to set a default worktime per day (to calculate overhours)
* add option to set a editor for editing the file
* add "--time=hh:mm" to all creation scripts
* add "--raw" to all time_registration_list_days scripts (output with comments)
* add "configure" beside "install"
* create a script called "resume_last_task" or "continue_with_last_task"
* create a script called "started" with the mandatory argument "--at=hh:mm"
* create a script called "record_days_of_holiday" with mandatory arguments "--from-date=dd[.mm[.yyyy]]" and "--to-date=dd[.mm[.yyyy]]"
* create a script called "record_day_of_holiday" with mandatory argument "--date=dd[.mm[.yyyy]]"
* create a script called "record_days_of_illness" with mandatory arguments "--from-date=dd[.mm[.yyyy]]" and "--to-date=dd[.mm[.yyyy]]"
* create a script called "record_day_of_illness" with mandatory argument "--date=dd[.mm[.yyyy]]"
* create phar archive
* create gui tool
* create shell auto completion by using [this](https://github.com/bazzline/php_component_cli_readline)
* create documentation
* create hidden json file for each entry ({version: 0, timestamp: 124, subject: "tra la la", description: "tru lu lu", type: [entry|comment]})
* create install script (path should be /opt/time-registration/)
* move configuration files into ".config/time-registration"
* remove short flags like "-f"
* refactored `time_registration` and replaced existing code with a bash script you can run for ever
* added support for continue a task via the new `time_registration`

### To Change

## [Unreleased]

### Added

* added support for windows

### Changed

* removed deprecated `array();` with `[];`
* started migrating code to php 7

## [0.2.0](https://github.com/time-registration/local_builder/tree/0.2.0) - released at 27.07.2017

### Added

* add "vim +/<current date>" to quickly edit current day if you call edit_current_week
* added "edit_current_week"
* added "start_without_subject"

## [0.1.3](https://github.com/time-registration/local_builder/tree/0.1.2) - released at 02.12.2015

### Changed

* fixed a bug in "list_current_day"
* fixed a bug in "list_days"
* fixed a bug in "list_last_day"
* fixed a bug in "list_last_week"
* refactored commandy by centralizing logic
* renamed "time_registration_create_configuration_file" to "time_registration_install"
* renamed "start" to "start_with"
* renamed "start_a_\*" to "take_a_\*"

## [0.1.2](https://github.com/time-registration/local_builder/tree/0.1.2) - released at 02.12.2015

### Added

* added "-f|--force" and "-n|--now" to "time_registration_start" to force (overwriting) an existing time or to round down the current time (by using now)

### Changed

* renamed "time_registration_create_an_entry" to "time_registration_start"
* shifted "lunch" and "pause" into description

## [0.1.1](https://github.com/time-registration/local_builder/tree/0.1.1) - released at 02.12.2015

### Changed

* removed the ".md" suffix since we are not using the markdown syntax
* updated depentency

## [0.1.0](https://github.com/time-registration/local_builder/tree/0.1.0) - released at 29.11.2015

### Added

* initial plumper release
* create year in data automatically
