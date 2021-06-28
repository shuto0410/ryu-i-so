load data local infile "/var/www/html/ryu-i-so/dbtest/ScheduleType.csv"
into table ScheduleTypeTable
fields terminated by ','
optionally enclosed by '"';

load data local infile "/var/www/html/ryu-i-so/dbtest/AnnualSchedule.csv"
into table AnnualScheduleTable
fields terminated by ','
optionally enclosed by '"';

load data local infile "/var/www/html/ryu-i-so/dbtest/Station.csv"
into table StationTable
fields terminated by ','
optionally enclosed by '"';

load data local infile "/var/www/html/ryu-i-so/dbtest/BusSchedule.csv"
into table BusScheduleTable
fields terminated by ','
optionally enclosed by '"';
