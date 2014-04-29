---
layout: post
title: Automate jobs using crontab
categories: Technology
tags: Cron
---

1. Commands
	
		crontab [-u username] [-e|-l|-r]

	Examples:
	* Edit: crontab -e
	* Display: crontab -l
	* Remove: crontab -r

2. Syntax of crontab file

		[minute:0-59] [hour:0-23] [date:1-31] [month:1-12] [day of week: 0-6, Sunday=0] [command to be executed]

	* *: anytime
	
	* ,: time intervals

	Example: Execute the command at 3am and 6am everyday
		0 3,6 * * * command

	* -: time range

	Example: Execute the command at the 20th minutes between 8am and 11am
		20 8-11 * * * command

	* /n: every n time instance

	Example: Execute the command every 15 minutes
		*/15 * * * * command

	More examples:

		* * * * * <command> #Runs every minute
		30 * * * * <command> #Runs at 30 minutes past the hour
		45 6 * * * <command> #Runs at 6:45 am every day
		45 18 * * * <command> #Runs at 6:45 pm every day
		00 1 * * 0 <command> #Runs at 1:00 am every Sunday
		00 1 * * 7 <command> #Runs at 1:00 am every Sunday
		00 1 * * Sun <command> #Runs at 1:00 am every Sunday
		30 8 1 * * <command> #Runs at 8:30 am on the first day of every month
		00 0-23/2 02 07 * <command> #Runs every other hour on the 2nd of July
		@reboot <command> #Runs at boot
		@yearly <command> #Runs once a year [0 0 1 1 *]
		@annually <command> #Runs once a year [0 0 1 1 *]
		@monthly <command> #Runs once a month [0 0 1 * *]
		@weekly <command> #Runs once a week [0 0 * * 0]
		@daily <command> #Runs once a day [0 0 * * *]
		@midnight <command> #Runs once a day [0 0 * * *]
		@hourly <command> #Runs once an hour [0 * * * *]

3. Further information
		
		man crontab
