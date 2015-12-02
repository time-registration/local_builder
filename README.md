# Local Time Registration File Builder

Free as in freedom local time registration file builder.
This component helps you tracking your daily tasks.

Give it a try by executing *time_registration*.

# Why?

* 15 minutes is minimum

# History

* upcoming
    * @todo
        * create phar archive
        * create gui tool
        * create shell auto completion by using [this](https://github.com/bazzline/php_component_cli_readline)
        * create documentation
        * create hidden json file for each entry ({version: 0, timestamp: 124, subject: "tra la la", description: "tru lu lu", type: [entry|comment]})
        * create install script (path should be /opt/time-registration/)
* [0.1.2](https://github.com/time-registration/local_builder/tree/0.1.2) - released at 02.12.2015
    * added "-f|--force" and "-n|--now" to time_registration_start to force (overwriting) an existing time or to round down the current time (by using now)
    * renamed time_registration_create_an_entry to time_registration_start
    * shifted "lunch" and "pause" into description
* [0.1.1](https://github.com/time-registration/local_builder/tree/0.1.1) - released at 02.12.2015
    * removed the ".md" suffix since we are not using the markdown syntax
    * updated depentency
* [0.1.0](https://github.com/time-registration/local_builder/tree/0.1.0) - released at 29.11.2015
    * initial plumper release
    * create year in data automatically
    * time_registration
    * time_registration_create_an_entry
    * time_registration_create_configuration_file
    * time_registration_finish_the_day
    * time_registration_finish_the_day_with_holiday
    * time_registration_finish_the_day_with_illness
    * time_registration_list_current_day
    * time_registration_list_days
    * time_registration_list_last_day
    * time_registration_list_last_week
    * time_registration_start_a_break
    * time_registration_start_lunch
