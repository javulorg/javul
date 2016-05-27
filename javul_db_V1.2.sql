Database : javul
--------------------------------------------------------

users Table :
---------------------------------
id int(10) PK AI,
first_name varchar(20),
last_name varchar(20),
email varchar(20) not null unique,
password varchar(255)
phone varchar(20),
mobile int(15),
address varchar(255),
job_skills varchar(255) ( ids from job_skills table. it can be multiple with comma separated ),
area_of_interest varchar(255) ( ids from area_of_interest table. it can be multiple with comma separated),
created_at datetime,
updated_at datetime,
deleted_at datetime
------------------------------------------

user_funds table: ( to display Funds awarded (lifetime and last 6 months) on user profile page. we need this table )
-------------------------------------------
id int(10) PK AI,
created_by int(10) FK ( references users table ),
user_from_id int(10) FK ( references users table ),
user_to_id  int(10) FK (references  users table ),
amount float(10,2),
type varchar(20) ( donated or rewarded)
created_at datetime,
updated_at datetime,
deleted_at datetime

--------------------------------------------

countries table:
--------------------------------------------
id int(10) PK AI,
shortname varchar(20),
name varchar(20)
created_at datetime,
updated_at datetime,
deleted_at datetime
----------------------------------------------

states table:
--------------------------------------------
id int(10) PK AI,
country_id int(10) FK ( references countries table ),
name varchar(20),
created_at datetime,
updated_at datetime,
deleted_at datetime
----------------------------------------------

cities table:
--------------------------------------------
id int(10) PK AI,
state_id int(10) FK ( references states table ),
name varchar(20)
created_at datetime,
updated_at datetime,
deleted_at datetime
----------------------------------------------

units Table :
--------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references users table ),
name varchar(255) not null,
description text,
category_id int(10) FK ( references unit_categories )( it can be multiple , we can store it using comma separator),
credibility varchar(50) ( it can be platinum, glod, silver or bronze ),
location int(10) FK ( references cities table),
status varchar(10) ( it can be active or disabled ),
parent_id int(10) ( id of this table to make unit child of unit),
created_at datetime,
updated_at datetime,
deleted_at datetime
----------------------------------------------

related_units table:
----------------------------------------------
id int(10) PK AI,
unit_id int(10) FK ( references units table ),
related_to int(10) FK ( references units table )
created_at datetime,
updated_at datetime,
deleted_at datetime
----------------------------------------------

unit_funds table:
----------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references users table ),
unit_id int(10) FK ( references units table ),
objective_id int(10) FK ( references objectives table),
amount float(10,2),
fund_type varchar(20) ( unit or objective ),
transaction_type varchar(20) ( donated or rewarded)
created_at datetime,
updated_at datetime,
deleted_at datetime
----------------------------------------------

unit_categories Table:
----------------------------------------------
id int(10) PK AI,
category_name varchar(255),
parent_id int(10) ( id of this table ),
status varchar(20) ( it can be pending or approved ),
created_at datetime,
updated_at datetime,
deleted_at datetime
-----------------------------------------------------

objectives Table :
---------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references users table ),
name varchar(255),
description text,
unit_id int(10) FK ( references units table ),
status varchar(20) ( it can be in-progress, completed or archieved ),
parent_id int(10) ( id of this table to make child of objective. ),
created_at datetime,
updated_at datetime,
deleted_at datetime
----------------------------------------------

objective_importance_level table 
----------------------------------------------
id int(10) PK AI,
objective_id int(10) FK ( references objective table ),
user_id int(10) FK ( references users table ),
created_at datetime,
updated_at datetime,
deleted_at datetime
-------------------------------------------------------
 
tasks Table:
----------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references users table ),
name varchar(255),
summary varchar(255),
description text,
skills varchar(20) ( From job_skills table. it can be multiple with comma separator),
estimated_completion_time datetime,
reward float(10,2) ( if user entered amount then it will get by the user to whome task is assigned when he/she complete the task. if it is empty then user will get points as mentioned in motivation only)
unit_id int(10) FK ( references units table),
objective_id int(10) FK ( references objectives table ),
file_attchments text,
assign_to int(10) FK ( references users table : user_id ),
status int(10),
created_at datetime,
updated_at datetime,
deleted_at datetime


status can be 
1) editable ( Anyone can edit the task and improve it.)
2) waiting for approval ( Task cannot be edited anymore. It is now waiting to be approved for bidding. )
3) Open for Bidding ( People can bid on it now.)
4) Bid Selection ( Bidding period has ended. Waiting to assign to selected user )
5) Assigned ( Task is assigned to user. )
6) In Progress ( Work in progress by the person to whom the task was assigned. )
7) Work Evaluation ( User submits the completed task for evaluation. )
8) Completed ( Task has been completed )
9) Cancelled ( Task was cancelled at some point e.g. it was later seen that it was not a valid or viable task or it was abandoned for some reason )
	
---------------------------------------------------------------

site_activity table:
---------------------------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references users table ),
comments text,
created_at datetime,
updated_at datetime,
deleted_at datetime

---------------------------------------------------------------

user_tasks table:
------------------------------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references users table ),
task_id int(10) FK ( references tasks table ),
quality_feedback int(10)
time_feedback int(10)
--------------------------------------------------------------------


user_award_nominations table:
------------------------------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references users table ),
leadership int(10),
task_completion int(10),
ingenuity int(10),
mediator_facilitator int(10),
accountibility_award int(10)
created_at datetime,
updated_at datetime,
deleted_at datetime
-------------------------------------------------------------------

user_awards table:
-------------------------------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references users table ),
leadership int(10),
task_completion int(10),
ingenuity int(10),
mediator_facilitator int(10),
accountibility_award int(10)
created_at datetime,
updated_at datetime,
deleted_at datetime
-------------------------------------------------------------------

task_actions table:
--------------------------------------------------
id int(10) PK AI,
task_id int(10) FK ( references tasks table ),
user_id int(10) FK ( references users table ),
name varchar(255),
description text,
status varchar(20) ( it can be pending or completed ),
created_at datetime,
updated_at datetime,
deleted_at datetime
--------------------------------------------

activity_points Table:
--------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references Users table ),
unit_id int(10) FK ( references Units table ),
points int(10)
comments varchar(200),
type varchar(20) ( where type is unit,objective or task ),
created_at datetime,
updated_at datetime,
deleted_at datetime


Ex : 
	1) if activity points for unit creation then we will add only unit id, where objective_id, task_id are null
	2) if activity points for objective creation then we will add only objective_id, where unit id, task_id are null
	3) if activity points for task creation then we will add only task_id, where unit id, objective_id are null
	
-------------------------------------------------------------------------------------------------------------------

job_skills table:
--------------------------------------------------
id int(10) PK AI,
skill_name varchar(20),
parent_id int(10) ( id of this table to make parent skill ),
created_at datetime,
updated_at datetime,
deleted_at datetime
-----------------------------------------------------------

area_of_interest table:
----------------------------------------------------------
id int(10) PK AI,
title varchar(255),
parent_id int(10) ( id of this table to make it child ),
created_at datetime,
updated_at datetime,
deleted_at datetime
---------------------------------------------------------------

issues table ( issue reporting )
---------------------------------------------------------------
id int(10) PK AI,
user_id int(10) FK ( references users table ),
title varchar(255),
description text,
file_attchments text,
status varchar(30) ( it can be unverified, verified or resolved ),
resolution text,
task_id int(10) FK ( references tasks table),
unit_id int(10) FK ( references units table),
objective_id int(10) FK ( objectives table),
created_at datetime,
updated_at datetime,
deleted_at datetime
---------------------------------------------------------------

issues_importance table
---------------------------------------------------------------	
id int(10) PK AI,
user_id int(10) FK ( references users table ),
issue_id int(10) FK ( references issues table),
point int(10) ( its 1)
created_at datetime,
updated_at datetime,
deleted_at datetime
---------------------------------------------------------------


For Information : 
Donate money:
	VD1: Donate to Unit ( it will record into unit_fund with unit_id to donate or awarded and objective_id is null where fund_type is units)
	VD2: Donate to Objective ( it will record into unit_fund with objective_id to donate or awarded and unit_id is null where fund_type is objectives)
	VD3: Donate to User ( it will record into user_fund with user_from_id and user_to_id with amount )
	VD5: Donate for General purpose ( it will record into unit_fund with objective_id and unit_id is null where fund_type is general_purpose)
