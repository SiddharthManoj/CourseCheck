<?php
session_start();

if (isset($_SESSION['un'])) {
	unset($_SESSION['un']);
}
