# CourseCheck

The HTTP-facing files are in `http`; these should be copied to the HTTP server's directory (e.g. `/usr/share/nginx/www`). Another file, `loop.php`, should be run in the background at all times (e.g. `nohup loop.php &`).

# TODO

## Features

#### Alt text for elements (e.g. "Logout" for CourseCheck header).

This is good for UX and also disability accessibility.

#### Delete functionality for class rectangle

#### Color coded rectangles based on school (or maybe just different color for each rectangle while maintaing a good color theme)

I'm not sure about filling the page with lots of different colors. If we use a lot of varied colors, they should be encoding useful and pertinent information. This, of course, doesn't exclude giving the page itself a nice colorscheme like cardinal/gold. - WA

I agree. I do think their should be some differentiator between the class rectangles to some extent. Not too much to overwhelm the user of course. - GO

What about a tint reflecting how recently the seats opened up? So the rectangles would get progressively darker at varying steps. We could do something where maybe a week ago is the darkest and a minute ago is the brightest and do a log scale between them. - WA

If you'd be up to do that then sure. That would also take care of my suggestion for highlighting changes for a class rectangle if a user switches back to our site from another tab or something. - GO

#### Have each class rectangle link to web registration page so users can log in quickly

Good idea. URL scheme is e.g. `https://camel2.usc.edu/webreg/crsesoffrd.asp?COURSE=CSCI-103&TERM=20151&DEPT=CSCI`. We should make sure that this path is preserved even if the user has to go through the Shib authentication page. - WA

That could be pretty difficult, but surely possible. In the meantime we could just have it link to here:
"https://camel2.usc.edu/webreg/Login.asp". - GO

I'm currentl going through hell with my USC account because the web registration made me reset my pin and asked for an 8-character password, but the prompt only allows 6. Could someone see if the link I posted works without already being logged into Shibboleth? - WA

I tried it without being logged in and was directed to the link I posted, which I don't know how to log in to. I just go through my.usc.edu. - GO

#### Authenticate users with Shibboleth so we can link each class rectangle to the correct web reg. page

#### Account management page for password resets, email changes, account deletion, etc.

Might be doable using some SG API; otherwise we could just use a PHP script with the SGPHP stuff. - WA

#### Set up admin@coursecheck.me or webmaster@coursecheck.me for customer support. Would require setting up Postfix and Dovecot. Make sure we all have access to email.

#### Text message alerts instead of or in addition to email

I *think* we can do this using the email-to-SMS features that most cell providers offer (e.g. `5555555555@vtext.com`. This would require figuring out which provider owns a given number.

(http://www.digitaltrends.com/mobile/how-to-send-e-mail-to-sms-text/)
(http://martinfitzpatrick.name/list-of-email-to-sms-gateways/)

#### Live suggestion search bar with additional parameters instead of just dept. and id (this would be good so users don't have to lookup ID on web reg site)

## Fixes

#### Use GitHub's built-in issue tracking to manage to-dos - WA

Does this mean we shouldn't use the README for to-dos? - GO

#### ~~Make a new GHub organization and use a private repo for this. While I'm all for keeping this free and open-source, I think we should still keep development private at least for now.~~ - WA

It seems to me the goal is to make this site as good as possible, while it's in private development, then when we release it to the masses we make it open-source. By then I imagine we'd be far enough ahead of anyone else that they'd rather just use our awesome site than try to make their own version. It's worth mentioning that I appreciate the open-source ethos and wouldn't mind others utilizing our work to make something else that's cool (like a Chrome extension for Ben). - GO

#### Better sorting/highlighting

Yes, sorting the classes by most-recent updates is a big one. This shouldn't be too hard; we'd want to have a time field in the section entries in Mongo that would just be seconds since the UNIX epoch (e.g. the default result of `time()` in PHP. Then update that entry whenever a class's open seats increase, and sort by that before returning the JSON-ified class list to the homepage. - WA

Going a little further, it might be a good idea to have a notification sound play in the browser whenever a class updates. So users could have the site running in the background. Also, this is a little less necessary and subjective, but having class rectangles that were updated have some distinctive visual identifier, like a bright outline, could also be good. So if a user switches back to the site from another tab, he or she can easily see what changed. - GO

Okay, we could do that with a JS loop on the page and add something into the DB about whether a new update is waiting for each user's sections.

Playing a sound notification should be easy from what I can see:
(http://stackoverflow.com/a/9419328)
(http://www.w3schools.com/html/html5_audio.asp)

#### More complete class section info in rectangle

#### Identify any remaining class recognition errors apart of the Schedule of Classes API

#### 12 hour time instead of military time on class rectangle

(http://stackoverflow.com/a/14415768)

## Other

#### About/info page and help page

#### Create a professional logo (it could just look like one of those generic startup company t-shirts)
Things the logo {c,sh}ould incorporate: registration, adding, watching, updating. Two C's mean some interesting ways to incorporate letters if we want to. - WA

#### Snazzy pastel-ized cardinal and gold color theme

Some nice-looking possible colors  
"#E65B5E"  
"#F8CA8C"  
"#FA7E73"

#### Nicer looking JS alerts

(http://tristanedwards.me/sweetalert)

#### For serious testing we could have the site check local JSON files that we will deliberately change to verify the changes on the site are correct

Yes, we should set up a testing DB as well which pulls from local JSON. In terms of testing, we obviously need a way for everyone to develop simultaneously. We already have the personal HTML folders for each dev (which are symlinked to the HTTP server's active folder); we can further split those into:

* a testing folder, where you can write random PHP and HTML and whatever
* a branch of our main Git repo, where everyone can write code for the website

and then when we meet up we can merge our branches after reviewing everyone's code - WA

#### Search Engine Optimization tactics

* About page  
* SSL certificate  
* Get mentioned on other sites (Daily Trojan, ACM)  
* Spread the word on Twitter, Facebook

#### Scale up as we get more users

#### Monetization ideas (consider the toll these would take on the server, etc.)

Priority queue to determine the order and time each email is sent. We'd have to determine how users get into the queue and whether they can move up in the queue through some monetary means (charity).

"Instant results" for a nominal fee. You would get notified as soon as the server found new openings in a class (which is the way it works now). If you didn't pay for these, you'd get added to the queue which would be notified one by one. So the process would look like:

Server finds new openings for a class -> sends email to all watching users who are premium -> (5 minute wait) sends email to first free user -> (5 minute wait) sends email to second free user -> etc

Maybe I'm not understanding this completely, but how would the priority queue differ from instant results, since they both involve emails being sent out at different rates depending on money being spent? Overall, while the price should be low, it shouln't be low enough so that most people have no problem buying it and then the premium option becomes the standard. - GO

The paying users receive an email as soon as the server knows that there are new openings in a class they care about. The 5 minute delay has nothing to do with the 5-minute polling frequency of the loop.

If the loop checked for new classes every 10 seconds, or constantly, then the sending schedule would still look like

Server finds new openings for a class -> sends email to all watching users who are premium -> (5 minute wait) sends email to first free user -> (5 minute wait) sends email to second free user -> etc - WA
