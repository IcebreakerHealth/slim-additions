<?php
/**
 * Global functions.
 *
 * If you're putting something in here you better have a damn good reason and the approval of all other PHP developers on the team.
 */

/**
 * h
 *
 * For outputting strings. Add all sorts of clean methods in here as desired.
 */
function h($text) {
	return htmlspecialchars($text);
}