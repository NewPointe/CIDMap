# CIDMap #

A simple set of php pages for showing the places we impact during Community Impact Day.

Uses the Google Maps API to show points on an interactive map and has a dashboard to manage data.

----------

Map is **index.php**

Data Manager is **manage.php**

Everything else is just support files.

----------

When uploading the CSV data file, lines **must** be in one of the following formats:

    Place Name, Address, Job Description

    Place Name, #, #, Address, Job Description

    Place Name, Latitude, longitude, Address, Job Description, true/false (to override geocoding)

It must not have column titles!
