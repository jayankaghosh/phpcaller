
__PHPCALLER - A PHP wrapper for the Truecaller API__

MADE WITH L<3VE BY __j0y__ <<jayankaghosh@gmail.com>>

DISCLAIMER: This was purely a hobby project with no intention of distributing or marketing this software

__PHPCaller is a command line tool made in PHP to fetch data from the truecaller API__

To use the PhpCaller, first you'll need to get your "bearer ID". For that you can go to http://www.truecaller.com/ from your PC and search for any number. It will ask you to login or complete an oAuth procedure (if you haven't already logged in to their site).
After the login is done open your console and paste this script (don't worry, the changes made are temporary, and it's not a malware)

    (function(setRequestHeader) {
        XMLHttpRequest.prototype.setRequestHeader = function(key, val) {
         if(key == "Authorization") document.write("<h1>"+val.replace("Bearer ", "")+"</h1>");
        };
    })(XMLHttpRequest.prototype.setRequestHeader);

Now search for another number, and you should be able to see a code in your screen. That is your bearer ID. Copy it and run the command `php truecaller setBearer <your_bearer_id>`

So if your bearer ID is `Y99Opnpg2e5_KDZpys6RRASvym7` then you should type 

    php truecaller setBearer Y99Opnpg2e5_KDZpys6RRASvym7 

to set your bearer 

Now you're all set to go! Type,

    php truecaller search <number>

to get a JSON response from truecaller about the number

Example:

    php truecaller search 9876543210
    
You can also type `php truecaller list` or `php truecaller help` to get a list of all commands or to read this README respectively.

There is also a browser implementation of it, in `index.php`. Check the code for further implementation details or feel free too drop me a mail if you have any questions!
