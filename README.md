<h1><a href="http://p4.mahe-cscie-15.biz">CSCIE-15 P4 - Quick Project Management (QPM)</a></h1>
<p>The QPM is a project management tool. It helps users manage small projects like a Agile sprint. It has 3 different user interfaces for the 3 different roles that it supports.</p>
<h2>Project Manager Interface</h2>
<p>This is the default interface. The user signing in to the website will be given this role by default. This interface provides the user with the following privileges.</p>
<ol>
    <li>Create new projects. </li>
    <li>Edit projects details like</li>
    <ol type="a">
        <li>Project Description</li>
        <li>Start and End date</li>
        <li>Project Status - Green/Yellow/Red</li>
    </ol>
    <li>View the Gantt chart of the project</li>
    <li>Add, edit and delete tasks, task groups and milestones.</li>
    <li>Add team members for the projects.</li>
</ol>
<h2>Administrator Interface</h2>
<p>This is the administrator's interface. This lets users to</p>
<ol>
    <li>Add new users.</li>
    <li>Edit user details like</li>
    <ol type="a">
        <li> First name</li>
        <li> Last name</li>
        <li> Email address.</li>
    </ol>
    <li>Change user's privileges and provide users with administrator access.</li>
    <li>Activate/deactivate users. </li>
    <li>Reset passwords of users.</li>
</ol>
<h2>Team Member Interface</h2>
<p>This is interface allows users to</p>
<ol>
    <li>View task list</li>
    <li>Edit task details</li>
    <li>Change task status/start date and end date</li>
</ol>
<p>Here are the main features of this site</p>

<h3>1. Dynamic Gantt chart</h3>
<p>The PM interface allows the user to see a dynamic Gantt Chart of the project. When the user creates a project, QPM creates a Gantt chart for the project with a root task group with the same name and parameters of the project. The root task group cannot be edited. The PM can then add, edit, and delete the tasks, milestones and task groups. Once a task group is deleted, all the tasks and milestones in that group is also deleted.</p>

<h3>2. Email notifications</h3>
<p>QPM sends out email notifications when a user is activated or deactivated. Those emails are just notifications that the user receives. QPM also sends out email notification when the password is reset. That email contains a URL that the user can use to reset his/her password.</p>

<h3>3. Calendar view task list</h3>
<p>The TM interface has a interactive calendar view of the task list along with a regular task list. The calendar interface allows the user to edit the task details by clicking on the task on the calendar. They can also drag and drop the task to change the task dates and also resize the task to change it's duration.</p>

<h3>4. Admin interface</h3>
<p>The admin interface allows the admin to manage all the users of QPM. All users who sign up has the Project Manager access. But the Admin can create Team Member users and other admins. The admin can also provide and revoke admin access to other users. There is no single admin user and the admin user cannot created using the UI. The admin user either has to be inserted directly using the database or using one of the following user ids. The password for all of them are 'password'.</p>
<ul>
    <li>barney.stinson@sharklasers.com</li>
    <li>bettywhite@sharklasers.com</li>
    <li>jerryseinfeld@sharklasers.com</li>
    <li>mahendran.nair@gmail.com</li>
    <li>vimal.nair@sharklasers.com</li>
</ul>
<p>The email notifications send out to the 'sharklasers.com' email addresses can be viewed at the www.guerillamail.com</p>

<h3>Multiple User Interfaces</h3>
<p>As it's already mentioned there are 3 different interfaces for the 3 different roles that QPM supports. These interfaces are easily distinguishable since there are captioned and color coded differently from eah other. QPM also lets the user switch between the roles without additional logins.</p>




