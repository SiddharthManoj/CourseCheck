# CourseCheck

The HTTP-facing files are in `http`; these should be copied to the HTTP server's directory (e.g. `/usr/share/nginx/www`). Another file, `loop.php`, should be run in the background at all times (e.g. `nohup loop.php &`).

# TODO

## Features

#### Alt text for elements (e.g. "Logout" for CourseCheck header).

This is good for UX and also disability accessibility.

#### Set up admin@coursecheck.me or webmaster@coursecheck.me for customer support. Would require setting up Postfix and Dovecot. Make sure we all have access to email.

## Fixes

#### Better sorting/highlighting

Yes, sorting the classes by most-recent updates is a big one. This shouldn't be too hard; we'd want to have a time field in the section entries in Mongo that would just be seconds since the UNIX epoch (e.g. the default result of `time()` in PHP. Then update that entry whenever a class's open seats increase, and sort by that before returning the JSON-ified class list to the homepage. - WA

Going a little further, it might be a good idea to have a notification sound play in the browser whenever a class updates. So users could have the site running in the background. Also, this is a little less necessary and subjective, but having class rectangles that were updated have some distinctive visual identifier, like a bright outline, could also be good. So if a user switches back to the site from another tab, he or she can easily see what changed. - GO

Okay, we could do that with a JS loop on the page and add something into the DB about whether a new update is waiting for each user's sections.

Playing a sound notification should be easy from what I can see:
(http://stackoverflow.com/a/9419328)
(http://www.w3schools.com/html/html5_audio.asp)

#### More complete class section info in rectangle

#### Identify any remaining class recognition errors apart of the Schedule of Classes API

## Other

#### About/info page and help page

#### ~~Create a professional logo (it could just look like one of those generic startup company t-shirts)~~
Things the logo {c,sh}ould incorporate: registration, adding, watching, updating. Two C's mean some interesting ways to incorporate letters if we want to. - WA

#### For serious testing we could have the site check local JSON files that we will deliberately change to verify the changes on the site are correct

Yes, we should set up a testing DB as well which pulls from local JSON. In terms of testing, we obviously need a way for everyone to develop simultaneously. We already have the personal HTML folders for each dev (which are symlinked to the HTTP server's active folder); we can further split those into:

* a testing folder, where you can write random PHP and HTML and whatever
* a branch of our main Git repo, where everyone can write code for the website

and then when we meet up we can merge our branches after reviewing everyone's code - WA

#### Monetization ideas (consider the toll these would take on the server, etc.)

Priority queue to determine the order and time each email is sent. We'd have to determine how users get into the queue and whether they can move up in the queue through some monetary means (charity).

"Instant results" for a nominal fee. You would get notified as soon as the server found new openings in a class (which is the way it works now). If you didn't pay for these, you'd get added to the queue which would be notified one by one. So the process would look like:

Server finds new openings for a class -> sends email to all watching users who are premium -> (5 minute wait) sends email to first free user -> (5 minute wait) sends email to second free user -> etc

Maybe I'm not understanding this completely, but how would the priority queue differ from instant results, since they both involve emails being sent out at different rates depending on money being spent? Overall, while the price should be low, it shouln't be low enough so that most people have no problem buying it and then the premium option becomes the standard. - GO

The paying users receive an email as soon as the server knows that there are new openings in a class they care about. The 5 minute delay has nothing to do with the 5-minute polling frequency of the loop.

If the loop checked for new classes every 10 seconds, or constantly, then the sending schedule would still look like

Server finds new openings for a class -> sends email to all watching users who are premium -> (5 minute wait) sends email to first free user -> (5 minute wait) sends email to second free user -> etc - WA
