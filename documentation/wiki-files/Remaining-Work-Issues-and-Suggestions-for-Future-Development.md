# Additional Work and Suggestions for the DPR System and DPR_Cal

## Remaining (GitHub) Issues from the First Semester of the Project

* Testing - Our Testing, especially on the API, could be greatly expanded
  * Testing (Course Page)
  * Testing (Section Page)
  * Testing (Admin Landing Page)
  * Testing (app.test.js)

## Suggestions for Future Development
### Additional Calendar Functionality
The requirements listed below are functionalities that the system was designed to include, but were not implemented during this first semester of the project. The sponsors may like these to be implemented for the future if this specific application is still worked on.

* RQ1 - Course Search
  * RQ1.1: The DPR Calendar system shall provide all users the ability to search for courses based on year, time period, title, keyword, activity, and district.
  * RQ1.2: The year will be able to search from the current year and the next year.
  * RQ1.3: The time period will be able to search either the entire year or from January to a specified month.
  * RQ1.4: Both title and keyword search will be able to search any word or phrase present in the title or training description respectively.
* RQ7: Course Certification Functionality
  * RQ7.1: The DPR calendar will have the ability for admins to view course certifications by attendee.
  * RQ7.2: The DPR calendar will have the ability for admins to view course certifications by class.
  * RQ7.3: The system will allow admins to search course certifications based on attendee’s last name.
  * RQ7.4: The system will have an option to update the certification if necessary.
  * RQ7.5: The system will allow admins to be able to view any current certification associated with the attendee.
  * RQ7.6: The system will allow admins to be able to edit the current certification date.
* RQ9: Evaluation Forms
  * RQ9.1: The DPR calendar will have the capability for admins to open a class for evaluation. 
  * RQ9.2: The DPR calendar will have the capability for admins to create an evaluation form for a class.
  * RQ9.3: The DPR calendar will have the capability for admins to view evaluations for a class.


### Future Remakes
There are many applications that are maintained by the NCDPR, and remaking one or several of these applications could be a suitable task for a future project. One that could potentially be remade is an application that NCDPR uses for searching documents, or some of the applications they use for managing finances. 
### Developing Next Project
The containerization done in this project allows for additional apps to be developed separately from the rest of the system. This means that the next team to take this project will have the freedom to choose whatever technologies they and the sponsors agree on for re-making new applications, or whatever other task they may decide to do.

The legacy database is large and unwieldy, with many tables containing columns of information that may be irrelevant to the function the table serves. The legacy database must remain in use for the remaining applications; however,  so rather than trying to normalize it, you may find it easier to take the fields of their tables, and link them with the dprCal_new database that we created for the calendar application. There may be some names that need to be changed, but things like the Users table could be reused for other applications.