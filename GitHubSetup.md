# Setting up GitHub on turing/hopper 

1. Generate SSH Key
Run command:
- ssh-keygen -t ed25519 -C "your@email.com"
    - keep default file location
    - add password

Run command:
- ssh-add ~/.ssh/id_ed25519

2. Go to GitHub website and add your SSH key

Try going to URL:
- https://github.com/settings/keys

Otherwise:
- Go to Settings for Profile
- Go to SSH and GPG Keys

Add SSH Key:
- Create a New SSH Key
- cat ~/.ssh/id_ed25519.pub
- Copy output and paste in public key
- Give it a Name and make sure authentication is selected
- And then add it to your profile!

3. Clone Karaoke Database
- Go into public_html
- git clone git@github.com:{username}/karaoke-database.git
- cd karaoke-database

4. Start coding!
- Create any files or scripts in this directory
- Commit whenever you've made any decent change to the program

- To access PHP file(s) on department server:
  https://students.cs.niu.edu/~{z-id}/karaoke-database/{filename}.php

- Common commands:
  git pull       - check if anyone has made any changes
  git add .      - add which files you would like in your commit
  git commit     - commit the files and add a messsage with what you changed
  git push       - push it to the repo to let others get your code

  git log        - check commit history 


- Check out the guidelines for writing a commit message:
  https://cbea.ms/git-commit/
