<?php

/**
  * SquirrelMail Calendar Plugin SQL Backend
  * Copyright (C) 2005 Paul Lesneiwski <pdontthink@angrynerds.com>
  * This program is licensed under GPL. See COPYING for details
  *
  */


   global $cal_dsn, $owned_calendars_query, $all_calendars_query, 
          $all_calendars_of_type_query, $all_owned_calendars_of_type_query,
          $all_writeable_calendars_of_type_query, $all_readable_calendars_of_type_query,
          $calendar_ical_query, $insert_cal_query, $update_cal_query, $delete_cal_queries,
          $insert_cal_owner_query, $insert_cal_reader_query, $insert_cal_writer_query,
          $delete_cal_owners_readers_writers_queries, $all_events_query, 
          $all_one_time_events_for_time_period_query, $all_recurring_events_query,
          $all_holidays_query, $event_ical_query, $insert_event_query,
          $insert_event_parent_cal_query, $insert_event_owner_query,
          $insert_event_reader_query, $insert_event_writer_query, $get_event_key_query,
          $delete_event_owners_readers_writers_parents_queries,
          $delete_event_queries, $update_event_query, $newline_regexp;


   // cal_dsn
   //
   // Theoretically, any SQL database supported by Pear should be supported
   // here.  The DSN (data source name) must contain the information needed
   // to connect to your database backend. A MySQL example is included below.
   // For more details about DSN syntax and list of supported database types,
   // please see:
   //   http://pear.php.net/manual/en/package.database.db.intro-dsn.php
   //
   $cal_dsn = 'mysql://user:password@localhost/squirrelmail_calendar';



   // newline_regexp
   //
   // A regular expression that identifies embedded newlines in the raw iCal 
   // streams for data being stored in the database.  Matches are turned into 
   // special symbols that are safe ways to embed newlines in iCal streams and
   // then store them in a database.  The special symbols are then decoded 
   // back into embedded newlines in the iCal stream when being read out of
   // the database.  
   //
   // The default given here works for MySQL, and may or may not be necessary 
   // for other database systems.  You may disable by setting this to an empty 
   // string.  The best test of this value is to create an event with a 
   // multi-line description.
   //
   //$newline_regexp = '';
   $newline_regexp = "/(\r\n|\r|\n)*(\\\\n)/i";



   // all_calendars_query
   //
   // The SQL query that will grab all calendars.
   // The query should return a list of calendar IDs.
   //
   $all_calendars_query = 'SELECT id FROM calendars';



   // all_calendars_of_type_query
   //
   // The SQL query that will grab all calendars that match the
   // given type.  The query should return a list of calendar IDs.
   //
   //   %1 in this query will be replaced with the internal calendar
   //      type identifier as needed.
   //
   $all_calendars_of_type_query = 'SELECT id FROM calendars WHERE type = "%1"';



   // owned_calendars_query
   //
   // The SQL query that will grab all calendars the the given user owns.
   // The query should return a list of calendar IDs.
   //
   //   %1 in this query will be replaced with the user's name
   //
   $owned_calendars_query = 'SELECT calendar_id FROM calendar_owners WHERE owner_name = "%1"';



   // all_owned_calendars_of_type_query
   //
   // The SQL query that will grab all calendars that match the
   // given type and have the given user as an owner.
   // The query should return a list of calendar IDs.
   //
   //   %1 in this query will be replaced with the user's name
   //   %2 in this query will be replaced with the internal calendar
   //      type identifier as needed.
   //
   $all_owned_calendars_of_type_query = 'SELECT calendars.id FROM calendars, calendar_owners WHERE calendars.type = "%2" AND calendar_owners.owner_name = "%1" AND calendar_owners.calendar_id = calendars.id';



   // all_readable_calendars_of_type_query
   //
   // The SQL query that will grab all calendars that match the
   // given type and have the given user as a readable user.
   // The query should return a list of calendar IDs.
   //
   //   %1 in this query will be replaced with the user's name
   //   %2 in this query will be replaced with the internal calendar
   //      type identifier as needed.
   //
   $all_readable_calendars_of_type_query = 'SELECT calendars.id FROM calendars, calendar_readers WHERE calendars.type = "%2" AND calendar_readers.reader_name = "%1" AND calendar_readers.calendar_id = calendars.id';



   // all_writeable_calendars_of_type_query
   //
   // The SQL query that will grab all calendars that match the
   // given type and have the given user as a writeable user.
   // The query should return a list of calendar IDs.
   //
   //   %1 in this query will be replaced with the user's name
   //   %2 in this query will be replaced with the internal calendar
   //      type identifier as needed.
   //
   $all_writeable_calendars_of_type_query = 'SELECT calendars.id FROM calendars, calendar_writers WHERE calendars.type = "%2" AND calendar_writers.writer_name = "%1" AND calendar_writers.calendar_id = calendars.id';



   // calendar_ical_query
   //
   // The SQL query that will retrieve the iCal contents of the given calendar.
   // The query should return the raw iCal for the desired calendar if the
   // calendar exists (empty results set otherwise).
   //   %1 in this query will be replaced with the target calendar ID
   //
   $calendar_ical_query = 'SELECT ical_raw FROM calendars WHERE id = "%1"';



   // insert_cal_query
   //
   // The SQL query that inserts a calendar into the database.
   //
   //   %1 in this query will be replaced with the calendar ID
   //   %2 in this query will be replaced with the calendar type
   //   %3 in this query will be replaced with the calendar name
   //   %4 in this query will be replaced with the calendar domain
   //   %5 in this query will be replaced with the calendar creation date
   //      in the form "Y-m-d H:i:s"
   //   %6 in this query will be replaced with the calendar last modified date
   //      in the form "Y-m-d H:i:s"
   //   %7 in this query will be replaced with the calendar's raw iCal text
   //
   $insert_cal_query = 'INSERT INTO calendars (id, type, name, domain, created_on, last_modified_on, ical_raw) VALUES ("%1", "%2", "%3", "%4", "%5", "%6", "%7")';



   // insert_cal_owner_query
   //
   // The SQL query that inserts a calendar owner into the database.
   //
   //   %1 in this query will be replaced with the calendar ID
   //   %2 in this query will be replaced with the calendar owner name
   //
   $insert_cal_owner_query = 'INSERT INTO calendar_owners (calendar_id, owner_name) VALUES ("%1", "%2")';



   // insert_cal_reader_query
   //
   // The SQL query that inserts a calendar reader (user) into the database.
   //
   //   %1 in this query will be replaced with the calendar ID
   //   %2 in this query will be replaced with the calendar reader name
   //
   $insert_cal_reader_query = 'INSERT INTO calendar_readers (calendar_id, reader_name) VALUES ("%1", "%2")';



   // insert_cal_writer_query
   //
   // The SQL query that inserts a calendar writer (user) into the database.
   //
   //   %1 in this query will be replaced with the calendar ID
   //   %2 in this query will be replaced with the calendar writer name
   //
   $insert_cal_writer_query = 'INSERT INTO calendar_writers (calendar_id, writer_name) VALUES ("%1", "%2")';



   // update_cal_query
   //
   // The SQL query that updates a calendar in the database.
   //
   //   %1 in this query will be replaced with the calendar ID
   //   %2 in this query will be replaced with the calendar type
   //   %3 in this query will be replaced with the calendar name
   //   %4 in this query will be replaced with the calendar domain
   //   %5 in this query will be replaced with the calendar creation date
   //   %6 in this query will be replaced with the calendar last modified date
   //   %7 in this query will be replaced with the calendar's raw iCal text
   //
   $update_cal_query = 'UPDATE calendars SET type = "%2", name = "%3", domain = "%4", created_on = "%5", last_modified_on = "%6", ical_raw = "%7" WHERE id = "%1"';



   // delete_cal_owners_readers_writers_queries
   //
   // An array of SQL queries that remove all calendar owners, readers and 
   // writers from the database.  Any number of queries may be included here.
   // The queries will be executed in the order given here.
   //
   //   %1 in all queries will be replaced with the calendar ID
   //
   $delete_cal_owners_readers_writers_queries = array(
                                  'DELETE FROM calendar_owners WHERE calendar_id = "%1"',
                                  'DELETE FROM calendar_readers WHERE calendar_id = "%1"',
                                  'DELETE FROM calendar_writers WHERE calendar_id = "%1"',
                                                     );



   // delete_cal_queries
   //
   // An array of SQL queries that remove a calendar from the 
   // database.  Any number of queries may be included here,
   // such that all child records can be deleted from any 
   // associated tables as necessary.  The queries will be 
   // executed in the order given here.
   //
   //   %1 in all queries will be replaced with the calendar ID
   //
   $delete_cal_queries = array(
                                  'DELETE FROM calendar_owners WHERE calendar_id = "%1"',
                                  'DELETE FROM calendar_readers WHERE calendar_id = "%1"',
                                  'DELETE FROM calendar_writers WHERE calendar_id = "%1"',
                                  'DELETE FROM calendars WHERE id = "%1"',
                              );



   // all_events_query
   //
   // The SQL query that will grab all events for a given calendar.
   // The query should return a list of event IDs.
   //
   //   %1 in this query will be replaced with the calendar ID
   //
   $all_events_query = 'SELECT event_id FROM events WHERE calendar_id = "%1"';



   // all_one_time_events_for_time_period_query
   //
   // The SQL query that will grab all one-time events for 
   // a given calendar that occur some time during a given
   // time/date interval.
   // The query should return a list of event IDs.
   //
   //   %1 in this query will be replaced with the calendar ID
   //   %2 in this query will be replaced with the begin 
   //      date-time in the form "Y-m-d H:i:s" (query is INCLUSIVE)
   //   %3 in this query will be replaced with the end 
   //      date-time in the form "Y-m-d H:i:s" (query is INCLUSIVE)
   //
   $all_one_time_events_for_time_period_query = 'SELECT event_id FROM events WHERE calendar_id = "%1" AND start <="%3" AND end >= "%2" AND isRecurring = "NO"';



   // all_recurring_events_query
   //
   // The SQL query that will grab all recurring events for 
   // a given calendar.  
   // The query should return a list of event IDs.
   //
   //   %1 in this query will be replaced with the calendar ID
   //
   $all_recurring_events_query = 'SELECT event_id FROM events WHERE calendar_id = "%1" AND isRecurring = "YES"';



   // all_holidays_query
   //
   // The SQL query that will grab all holidays for 
   // a given calendar.  
   // The query should return a list of event (holiday) IDs.
   //
   //   %1 in this query will be replaced with the calendar ID
   //
   $all_holidays_query = 'SELECT event_id FROM events WHERE calendar_id = "%1" AND isHoliday = "YES"';



   // get_event_key_query
   //
   // The SQL query that will grab the database key for the given event
   // in the given calendar.
   // The query should return one key value that identifies an event (as
   // used in foreign key relationships to child tables such as event_owners 
   // table)
   //   %1 in this query will be replaced with the target calendar ID
   //   %2 in this query will be replaced with the target event ID
   //
   $get_event_key_query = 'SELECT id FROM events WHERE event_id = "%2" AND calendar_id = "%1"';



   // event_ical_query
   //
   // The SQL query that will retrieve the iCal contents of the given event.
   // The query should return the raw iCal for the desired event if the
   // event exists (empty results set otherwise).
   //   %1 in this query will be replaced with the target calendar ID
   //   %2 in this query will be replaced with the target event ID
   //
   $event_ical_query = 'SELECT ical_raw FROM events WHERE event_id = "%2" AND calendar_id = "%1"';



   // update_event_query
   //
   // The SQL query that updates an event in the database.
   //
   //   %1 in this query will be replaced with the event ID
   //   %2 in this query will be replaced with the event start
   //      date-time in the form "Y-m-d H:i:s"
   //   %3 in this query will be replaced with the event end
   //      date-time in the form "Y-m-d H:i:s"
   //   %4 in this query will be replaced with the event domain
   //   %5 in this query will be replaced with YES if the event
   //      is an all-day event (NO if not)
   //   %6 in this query will be replaced with YES if the event
   //      is recurring (NO if not)
   //   %7 in this query will be replaced with YES if the event
   //      is a Task/TODO item (NO if not)
   //   %8 in this query will be replaced with YES if the event
   //      is a holiday (NO if not)
   //   %9 in this query will be replaced with the event priority
   //   %a in this query will be replaced with the event creation date
   //      in the form "Y-m-d H:i:s"
   //   %b in this query will be replaced with the event last modified date
   //      in the form "Y-m-d H:i:s"
   //   %c in this query will be replaced with the event's raw iCal text
   //   %d in this query will be replaced with the calendar ID
   //
   $update_event_query = 'UPDATE events SET start = "%2", end = "%3", domain = "%4", isAllDay = "%5", isRecurring = "%6", isTask = "%7", isHoliday = "%8", priority = "%9", created_on = "%a", last_modified_on = "%b", ical_raw = "%c" WHERE event_id = "%1" AND calendar_id = "%d"';



   // insert_event_query
   //
   // The SQL query that inserts an event into the database.
   //
   //   %1 in this query will be replaced with the event ID
   //   %2 in this query will be replaced with the event start 
   //      date-time in the form "Y-m-d H:i:s"
   //   %3 in this query will be replaced with the event end 
   //      date-time in the form "Y-m-d H:i:s"
   //   %4 in this query will be replaced with the event domain
   //   %5 in this query will be replaced with YES if the event 
   //      is an all-day event (NO if not)
   //   %6 in this query will be replaced with YES if the event 
   //      is recurring (NO if not)
   //   %7 in this query will be replaced with YES if the event
   //      is a Task/TODO item (NO if not)
   //   %8 in this query will be replaced with YES if the event
   //      is a holiday (NO if not)
   //   %9 in this query will be replaced with the event priority
   //   %a in this query will be replaced with the event creation date
   //      in the form "Y-m-d H:i:s"
   //   %b in this query will be replaced with the event last modified date
   //      in the form "Y-m-d H:i:s"
   //   %c in this query will be replaced with the event's raw iCal text
   //   %d in this query will be replaced with the calendar ID
   //
   $insert_event_query = 'INSERT INTO events (event_id, start, end, domain, isAllDay, isRecurring, isTask, isHoliday, priority, created_on, last_modified_on, ical_raw, calendar_id) VALUES ("%1", "%2", "%3", "%4", "%5", "%6", "%7", "%8", "%9", "%a", "%b", "%c", "%d")';



   // insert_event_owner_query
   //
   // The SQL query that inserts an event owner into the database.
   //
   //   %1 in this query will be replaced with the event foreign key
   //   %2 in this query will be replaced with the event owner name
   //
   $insert_event_owner_query = 'INSERT INTO event_owners (event_key, owner_name) VALUES ("%1", "%2")';



   // insert_event_reader_query
   //
   // The SQL query that inserts an event reader (user) into the database.
   //
   //   %1 in this query will be replaced with the event foreign key
   //   %2 in this query will be replaced with the event reader name
   //
   $insert_event_reader_query = 'INSERT INTO event_readers (event_key, reader_name) VALUES ("%1", "%2")';



   // insert_event_writer_query
   //
   // The SQL query that inserts an event writer (user) into the database.
   //
   //   %1 in this query will be replaced with the event foreign key
   //   %2 in this query will be replaced with the event writer name
   //
   $insert_event_writer_query = 'INSERT INTO event_writers (event_key, writer_name) VALUES ("%1", "%2")';



   // insert_event_parent_cal_query
   //
   // The SQL query that inserts an event parent calendar ID into the database.
   //
   //   %1 in this query will be replaced with the event foreign key
   //   %2 in this query will be replaced with the parent calendar ID
   //
   $insert_event_parent_cal_query = 'INSERT INTO event_parent_calendars (event_key, parent_calendar_id) VALUES ("%1", "%2")';



   // delete_event_owners_readers_writers_parents_queries
   //
   // An array of SQL queries that remove all event owners, readers,
   // writers and parents from the database.  Any number of queries 
   // may be included here.
   // The queries will be executed in the order given here.
   // 
   //   %1 in all queries will be replaced with the event foreign key
   //   
   $delete_event_owners_readers_writers_parents_queries = array(
                                  'DELETE FROM event_owners WHERE event_key = "%1"',
                                  'DELETE FROM event_readers WHERE event_key = "%1"',
                                  'DELETE FROM event_writers WHERE event_key = "%1"',
                                  'DELETE FROM event_parent_calendars WHERE event_key = "%1"',
                                                               );

   
   
   // delete_event_queries 
   // 
   // An array of SQL queries that remove an event from the
   // database.  Any number of queries may be included here,
   // such that all child records can be deleted from any 
   // associated tables as necessary.  The queries will be
   // executed in the order given here.
   //
   //   %1 in all queries will be replaced with the calendar ID
   //   %2 in all queries will be replaced with the event ID
   //   %3 in all queries will be replaced with the event foreign key
   //
   $delete_event_queries = array(
                                  'DELETE FROM event_owners WHERE event_key = "%3"',
                                  'DELETE FROM event_readers WHERE event_key = "%3"',
                                  'DELETE FROM event_writers WHERE event_key = "%3"',
                                  'DELETE FROM event_parent_calendars WHERE event_key = "%3"',
                                  'DELETE FROM events WHERE event_id = "%2" AND calendar_id = "%1"',
                                );
   
   
   
?>
