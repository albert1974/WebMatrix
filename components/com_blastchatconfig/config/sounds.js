/* do not remove first line */
if (typeof bcDataConfig === 'undefined') {bcDataConfig = {"system": {},"language": {},"groups": [],"rooms": [], "groupsrooms": [], "emoticons": {"emoticons": [], "groups": []},"sounds": {"sounds": [], "groups": []}};} var bcsound = null;

/* sound id 1 */
/* Defined in config_default/css/sounds.css file as .bcSoundMessage */
bcsound = new Object();
bcsound.id = 1;
bcsound.name = "Message";
bcsound.alt1 = ":msg:";
bcsound.alt2 = "";
bcsound.alt3 = "";
bcsound.iconClass = "bcSoundMessage";
bcsound.ogg = "";
bcsound.mp3 = "/components/com_blastchatconfig/config_default/sounds/msg.mp3";
bcsound.wav = "/components/com_blastchatconfig/config_default/sounds/msg.wav";
bcDataConfig.sounds.sounds.push(bcsound);
/* sound id 1 END */

/* sound id 2 */
/* Defined in config_default/css/sounds.css file as .bcSoundBeep */
bcsound = new Object();
bcsound.id = 2;
bcsound.name = "Beep";
bcsound.alt1 = ":beep:";
bcsound.alt2 = "";
bcsound.alt3 = "";
bcsound.iconClass = "bcSoundBeep";
bcsound.ogg = "";
bcsound.mp3 = "/components/com_blastchatconfig/config_default/sounds/mice.mp3";
bcsound.wav = "";
bcDataConfig.sounds.sounds.push(bcsound);
/* sound id 2 END */


/* sound group id 1 */
bcsoundgroup = new Object();
bcsoundgroup.id = 1;
bcsoundgroup.sounds = [1,2];
bcDataConfig.sounds.groups.push(bcsoundgroup);
/* emoticon group id 1 END */
