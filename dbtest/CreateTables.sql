use RD_bus;

create table ScheduleTypeTable(
  TypeCode int,
  ScheduleType varchar(20),
  primary key(TypeCode)
);

create table AnnualScheduleTable(
  ScheduleDate date,
  TypeCode int,
  primary key(ScheduleDate),
  foreign key(TypeCode) references ScheduleTypeTable(TypeCode)
);

create table StationTable(
  StationID int,
  StationName varchar(20),
  primary key(StationID)
);

create table BusScheduleTable(
  BusTime time,
  StationID int,
  BusType int,
  TypeCode int,
  foreign key(StationID) references StationTable(StationID),
  foreign key(TypeCode) references ScheduleTypeTable(TypeCode)
);
