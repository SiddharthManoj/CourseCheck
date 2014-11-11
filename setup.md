# How to use this repo to push changes to the site

1. Make your changes, then commit and push them.

2. Copy the `id_rsa` key in the home folder of the `admin` user to your computer: `scp coursecheck.me:/home/admin/id_rsa ~/.ssh/id_rsa_coursecheck.me_admin`

3. Add the following entry to your `~/.ssh/config`:

```
Host coursecheck.me_admin
	HostName coursecheck.me
	IdentitiesOnly yes
	IdentityFile ~/.ssh/id_rsa_coursecheck.me_admin
	user admin
```

4 Run `ssh-keygen` on your computer to generate a new SSH key pair. Call it `id_rsa_coursecheck.me_github`.

5. Add the key to your GitHub account (copy the contents of `id_rsa_coursecheck.me_github.pub` to the text area in the prompt on the website). I recommend giving it a title like `coursecheck.me` so you can distinguish it from your default key in the future.

6. If you want to make the live site run the latest Git code, do `scp ~/.ssh/id_rsa_coursecheck.me_github coursecheck.me_admin:.ssh/id_rsa`.

7. Next, `ssh coursecheck.me_admin`. Now you should be able to go into the repo directory (located at `/home/admin/CourseCheck`) and `git pull`, at which point the server code will be updated to the latest.

8. If your changes involved adding new files, modifying the server loop, or anything else that requires extra server configuration, tell me (Will) on the GroupMe and I'll make the changes.

9. When you're done pulling the changes, run `rm ~/.ssh/id_rsa` while logged in as the admin. This is so that other people in the team can't mistakenly use your GitHub account to access the repo.
