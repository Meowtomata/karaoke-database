# Setting up GitHub on turing/hopper 

## 1. Generate and Add SSH Key
Run the following commands on turing/hopper servers:

Run command:

ssh-keygen -t ed25519 -C "your@email.com"
  - when prompted for location, just press enter to keep default location
  - when prompted for password, add any password you want

Run command:

ssh-add ~/.ssh/id_ed25519

## 2. Go to GitHub website and add your SSH key

Try going to URL:
- https://github.com/settings/keys

Otherwise:
- Go to Settings for Profile
- Go to SSH and GPG Keys

Add SSH Key:
- Create a New SSH Key
- Run command: cat ~/.ssh/id_ed25519.pub
- Copy the output and paste it into the Key field on the GitHub website
- On the website, give the Key a name and make sure authentication is selected
- And then add it to your profile!

## 3. Clone Karaoke Database
- Go into public_html
- git clone git@github.com:{username}/karaoke-database.git
- cd karaoke-database

## 4. Start coding!
- Create any files or scripts in this directory
- Commit whenever you've made any decent change to the program

- To access PHP file(s) on department server:

  https://students.cs.niu.edu/~{z-id}/karaoke-database/{filename}.php
  - Fill in z-id with your z-id
  - Fill in filename with the file name you want

- Common commands:
  
| Command    | Description                                                  |
| ---------- | ------------------------------------------------------------ |
| git pull   | retrieve and check if anyone has made changes                |
| git add .  | add all files in current directory for commit                |
| git commit | commit changes and add a message and description for commit  |
| git push   | push commits to repo to let others use your code             |
| git log    | check commit history                                         |


- Check out the guidelines for writing a commit message:

  https://cbea.ms/git-commit/
