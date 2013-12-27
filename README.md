<h1>CSCIE-15 P4 - Quick Project Management (QPM)</h1>
The QPM is a project management tool. It helps users manage small projects like a Agile sprint. It has 3 different user interfaces for the 3 different roles that it supports.
Project Manager Interface
This is the default interface. The user signing in to the website will be given this role by default. This interface provides the user with the following privileges.
<ol>
<li>1. Create new projects. </li>
<li>2. Edit projects details like</li>
<ol type="a">
    <li>a. Project Description</li>
    <li>b. Start and End date</li>
    <li>c. Project Status - Green/Yellow/Red</li>
</ul>
<li>3. View the Gantt chart of the project</li>
<li>4. Add, edit and delete tasks, task groups and milestones.</li>
<li>5. Add team members for the projects.</li>
</ol>
Administrator Interface
This is the administrator's interface. This lets users to
1. Add new users.
2. Edit user details like
    a. First name
    b. Last name
    c. Email address.
3. Change user's privileges and provide users with administrator access.
4. Activate/deactivate users. 
5. Reset passwords of users.

Team Member Interface
This is interface allows users to
1. View task list
2. Edit task details
3. Change task status/start date and end date

Here are the main features of this site

1. Dynamic Gantt chart
The PM interface allows the user to see a dynamic Gantt Chart of the project. When the user creates a project, QPM creates a Gantt chart for the project with a root task group with the same name and parameters of the project. The root task group cannot be edited. The PM can then add, edit, and delete the tasks, milestones and task groups. Once a task group is deleted, all the tasks and milestones in that group is also deleted.

2. Email notifications
QPM sends out email notifications when a user is activated or deactivated. Those emails are just notifications that the user receives. QPM also sends out email notification when the password is reset. That email contains a 

