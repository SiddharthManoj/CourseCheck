# CourseCheck

The HTTP-facing files are in `http`; these should be copied to the HTTP server's directory (e.g. `/usr/share/nginx/www`). Another file, `loop.php`, should be run in the background at all times (e.g. `nohup loop.php &`).

# TODO

## Features

#### Alt text for elements (e.g. "Logout" for CourseCheck header).

This is good for UX and also disability accessibility.

#### Delete button for class rectangle

or just click the rectangle to delete? - WA

#### Color coded rectangles based on school (or maybe just different color for each rectangle while maintaing a good color theme)

I'm not sure about filling the page with lots of different colors. If we use a lot of varied colors, they should be encoding useful and pertinent information. This, of course, doesn't exclude giving the page itself a nice colorscheme like cardinal/gold. - WA

#### Have each class rectangle link to web registration page so users can log in quickly

Good idea. URL scheme is e.g. `https://camel2.usc.edu/webreg/crsesoffrd.asp?COURSE=CSCI-103&TERM=20151&DEPT=CSCI`. We should make sure that this path is preserved even if the user has to go through the Shib authentication page. - WA

#### Verify email is USC email and user has access to it  

Does it need to be a USC email? The user might want to use some other account. What are the disadvantages of disallowing non-USC emails? But definitely should add email verification. - WA

#### Allow for password resets (could SendGrid be used to handle this and above?)

Might be doable using some SG API; otherwise we could just use a PHP script with the SGPHP stuff. We should have an account management page where you can manage email changes, password changes, account deletion - WA

#### Customer support functionality through email or some other means

Yeah, could just set up admin@coursecheck.me or webmaster@coursecheck.me. Would require setting up Postfix and Dovecot which I could do in the future. - WA

#### ~~Enter key recognition for search bar (Garrett can do that)~~

#### Text message alerts instead of or in addition to email  

I *think* we can do this using the email-to-SMS features that most cell providers offer (e.g. `5555555555@vtext.com`. This would require figuring out which provider owns a given number. But this would be much more elegant and cheaper than fucking around with some startup's "revolutionary" API. - WA

#### Live suggestion search bar with additional parameters instead of just dept. and id (this would be good so users don't have to lookup ID on web reg site)

#### While we could stil do something along the lines of a queue with regards to the emailing, we could instead monetize a bit and charge users who want faster results, which on our end would just be sleeping the loop less than normal.

I think instead of intentionally gimping certain users, which really isn't a great business model, it would be better to do the queue, where basically free users are informed of the classes maybe 5 minutes after the earliest user in the queue. If the free users want "instant results" (which, of course, aren't quite instant because we aren't running the loop's body nonstop), they can pay some nominal fee for real-time updates. That also makes me think, I wonder how much bandwidth/memory/resources would be consumed if we had the loop on a really short delay (also, we wouldn't want it to be any faster than the SOC API updates). - WA
      
## Fixes

#### Make a new GHub organization and use a private repo for this. While I'm all for keeping this free and open-source, I think we should still keep development private at least for now. - WA

#### Better sorting/highlighting

Yes, sorting the classes by most-recent updates is a big one. This shouldn't be too hard; we'd want to have a time field in the section entries in Mongo that would just be seconds since the UNIX epoch (e.g. the default result of `time()` in PHP. Then update that entry whenever a class's open seats increase, and sort by that before returning the JSON-ified class list to the homepage. - WA

#### More complete class section info in rectangle 

#### Find any given class (would require plenty of testing)

How do you mean? - WA

#### 12 hour time instead of military time

## Other

#### About/info page and help page  

#### Create a professional logo (it could just look like one of those generic startup company t-shirts)

Things the logo {c,sh}ould incorporate: registration, adding, watching, updating. Two C's mean some interesting ways to incorporate letters if we want to. - WA

#### Snazzy USC color theme

I'd vote for pastel-ized cardinal and gold (the full-saturation versions would be a bit gaudy IMO) - WA

#### For serious testing we could have the site check local JSON files that we will deliberately change to verify the changes on the site are correct

Yes, we should set up a testing DB as well which pulls from local JSON. In terms of testing, we obviously need a way for everyone to develop simultaneously. We already have the personal HTML folders for each dev (which are symlinked to the HTTP server's active folder); we can further split those into:

* a testing folder, where you can write random PHP and HTML and whatever
* a branch of our main Git repo, where everyone can write code for the website

and then when we meet up we can merge our branches after reviewing everyone's code - WA

#### Should we make this code closed-source so no one can just copy our code and make the same thing with some changes?

I personally am not interesting in working on a non-free project. First off, the actual code isn't terribly complex, and most people who are driven enough to be copying a site will be able to figure out how to do what we've done in a week or two even if they can't see our actual code. (We figured it out from scratch in 36 hours). But I do think we shouldn't be distributing our PHP until we're sure everything's secure. - WA

####  What can we do for SEO (search engine optimization)?

Adding an about page would be the single biggest one. Another is getting an SSL certificate, because Google is starting to penalize unencrypted sites. Finally we'd want to get some links to our site from other reputable sites. - WA

#### Do we have to worry about scalability?

In terms of server beefiness? Yes, our $5 VPS won't cut it, probably, and we'll want to scale up at some point if this actually gets any momentum. - WA

#### In terms of professionalism, do we want to have a "team" github to store this?

Yes, as above. I'll get a more official, team, private repo set up. - WA
