# CronElectronicCourseReserve Plugin

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD",
"SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL"
in this document are to be interpreted as described in
[RFC 2119](https://www.ietf.org/rfc/rfc2119.txt).

**Table of Contents**

* [Install](#install)
* [Cron Job](#cron-job)
* [Mailing](#mailing)
* [Logging](#logging)
* [Dependencies](#dependencies)
* [License](#license)

## Install

This plugin MUST be installed as a
[Cron Plugin](https://www.ilias.de/docu/goto_docu_pg_56994_42.html).

The files MUST be saved in the following directory:

	<ILIAS_DIRECTORY>/Customizing/global/plugins/Services/Cron/CronHook/CronElectronicCourseReserve

Correct file and folder permissions MUST be
ensured by the responsible system administrator.

The plugin's files and folder SHOULD NOT be created, 
as root. 

## Cron Job

The plugin comes with an additional cron job task.

After completing the configuration in the **ElectronicCourseReserve**
plugin administration the ILIAS administrator has to
activate the corresponding cron job in the
**Administration » General Settings » Cron Jobs** section.
The ILIAS administrator MUST also choose the desired
schedule of this job.

If a cron job is crashed with with uncatchable
PHP error (which may occur in seldom cases), it has to
be reactivated (deactived/activated) or reset in
the cron job list.

The system administrator MUST add the **cron.php**
(located in **<ILIAS>/cron/**) to the
[cron table](https://wiki.ubuntuusers.de/Cron/)
(linked content in German language) and enter a appropriate
interval, e.g. once a day. The configured interval
MUST be smaller than the configured schedule for the
ILIAS cron job in the cron job administration.

## Mailing

For failed XML imports the plugin will send an error
report to a configured list of user accounts.

The system administrator MUST ensure a valid email server
configuration.
The ILIAS administration MUST ensure a valid mail system
configuration the global ILIAS administration
(**Administration » Mail » External**).

## Logging

The ILIAS log file is used whenever the plugin considers something
to be important to log.

## Dependencies

* ElectronicCourseReserve Plugin (https://gitlab.databay.de/ilias/esa_ui.git)

## License

See LICENSE file in this repository.