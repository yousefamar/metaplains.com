<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";
//TODO: Stuff.
include $root."/gui/stdTop.php"; ?>

<center>
	<p>
		<applet code="org.lwjgl.util.applet.AppletLoader" archive="lwjgl_util_applet.jar" width="1024" height="512">
			<param name="al_title" value="metaplains">
			<param name="al_jars" value="mpClient.jar, lwjgl.jar, lwjgl_util.jar">
			<param name="al_main" value="com.metaplains.core.GameApplet">
			<param name="al_windows" value="windows.jar">
			<param name="al_mac" value="macosx.jar">
			<param name="al_linux" value="linux.jar">
			<param name="al_solaris" value="solaris.jar">
			<param name="al_logo" value="mpappletlogo.gif">
			<param name="boxborder" value="false">
			<param name="centerimage" value="true">
			<param name="image" value="mpappletlogo.gif">
			<param name="al_debug" value="false">
			<param name="java_arguments" value="-Dsun.java2d.noddraw=true -Dsun.awt.noerasebackground=true -Dsun.java2d.d3d=false -Dsun.java2d.opengl=false -Dsun.java2d.pmoffscreen=false">
			<param name="separate_jvm" value="true">

			<?php
			print "<param name=\"userID\" value=\"".(userLoggedIn()?$userInfo["id"]:"-1")."\">";
			print "<param name=\"sessionID\" value=\"".(userLoggedIn()?$userInfo["sessionID"]:"")."\">";
			?>

			Please install Java 1.6 or later to run this applet.
		</applet><br><br>
		Controls:<br>
		WASD = Pan<br>
		T = Chat<br>
		Right-click = Move<br>
		Left-click = Place tree<br>
		<del>Ctrl + right-click + drag = Rotate world</del><br><br>
		Access to your hard drive has been disabled.
	</p>
</center>

<?php include $root."/gui/stdBottom.php"; ?>