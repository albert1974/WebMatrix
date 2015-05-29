/* do not remove first line */
if (typeof bcDataConfig === 'undefined') {bcDataConfig = {"system": {},"language": {},"groups": [],"rooms": [], "groupsrooms": [], "emoticons": {"emoticons": [], "groups": []},"sounds": {"sounds": [], "groups": []}};} var bcgroup = null;
	
/*********************************************************/
/* Privileges for chat group id 1, Guests */
/*********************************************************/
bcgroup = new Object();
bcgroup.id = 1;
bcgroup.name = "Guest";
bcgroup.iconClass = "bcUserGroupIconGuest";
//additional parameters here
bcDataConfig.groups.push(bcgroup);
/*********************************************************/
/* Privileges for chat group id 1 END */
/*********************************************************/

/*********************************************************/
/* Privileges for chat group id 2, Members */
/*********************************************************/
bcgroup = new Object();
bcgroup.id = 2;
bcgroup.name = "Member";
bcgroup.iconClass = "bcUserGroupIconMember";
//additional parameters here
bcDataConfig.groups.push(bcgroup);
/*********************************************************/
/* Privileges for chat group id 2 END */
/*********************************************************/

/*********************************************************/
/* Privileges for chat group id 3, Moderators */
/*********************************************************/
bcgroup = new Object();
bcgroup.id = 3;
bcgroup.name = "Moderator";
bcgroup.iconClass = "bcUserGroupIconModerator";
//additional parameters here
bcDataConfig.groups.push(bcgroup);
/*********************************************************/
/* Privileges for chat group id 3 END */
/*********************************************************/

/*********************************************************/
/* Privileges for chat group id 4, Admins */
/*********************************************************/
bcgroup = new Object();
bcgroup.id = 4;
bcgroup.name = "Admin";
bcgroup.iconClass = "bcUserGroupIconAdmin";
//additional parameters here
bcDataConfig.groups.push(bcgroup);
/*********************************************************/
/* Privileges for chat group id 4 END */
/*********************************************************/

/*********************************************************/
/* Privileges for chat group id 5, SuperAdmins */
/*********************************************************/
bcgroup = new Object();
bcgroup.id = 5;
bcgroup.name = "SuperAdmin";
bcgroup.iconClass = "bcUserGroupIconSuperAdmin";
//additional parameters here
bcDataConfig.groups.push(bcgroup);
/*********************************************************/
/* Privileges for chat group id 5 END */
/*********************************************************/