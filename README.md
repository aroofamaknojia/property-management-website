# property-management-website
Topic: This website is an internal property management tool that allows internal teams at a company see the listings the company owns.

Purpose: The primary reason this website was created was to provide the ability for internal teams at the company to have access to the information they need right away to allow them to make decisions, be able to filter through listings to find matches for customers that want specific things for the homes they want to live in, and allow the ability for properties to be offloaded (deleted) when contracts expire. I still wanted internal users to have the ability to share a search link for listings with the customers so I didn’t require log in to be able to see the site unlike other property management internal tools.

Instructions:

Sign-up/Login Details
1. Without having an account, a user is able to read on the website. However, if a user wants to update, create, or delete rows, they must create an account. The edit, delete, and add pages will not be visible until the user has created an account and logged in.
2. A user can create an account on the login page. There is a line on the bottom which allows the user to sign up for an account and they can sign up there. However, after the user has signed up, they must login to the account again.

Home Page
1. From the home page the users can click on the button for search form or use the search tab in the navigation menu to start searching for homes.
Search Form/Search Results
2. No field on the search form is mandatory. I did this because internal teams sometimes want to be able to see all the properties at once to make decisions. Additionally, all users regardless of whether they have an account or not, are allowed to look at the search results page. But users that have logged in can see the edit and delete buttons for listings.

Add Home
1. Only certain fields on the add home page are required. This page can only be viewed on the menu once the user has logged in. This allows for the page to have security and prevents customers of the company from adding results.

Source of the Data
https://www.kaggle.com/austinreese/usa-housing-listings

I took a very small subset of data from this source. Given the limited data upload size of cpanel and loading times, it was best to only focus on a small amount of data. However, there are some field I’ve added and removed from the data provided. For example, I’ve added home title and images.

Database Diagram:
The database is normalized with six tables. The main table is the home table that has all of the foreign keys that link to the different tables. The rest of the tables: parking, state, laundry, housing, and region provide more information about the home itself.

Extras:
1. Pagination (search_results.php): Search results are split up into multiple pages with a limit of 10 listings per page. When you are on the first page, the left arrow is not active and when you are on the final page, the right arrow is not active. The number of pages alters as new entries are inputted into the website.
2. Sessions (most to all pages): The session starts once the user is logged in and ends when they are logged out. Any action that gets completed between login and logout can be saved. However, actions are cleared once the user is logged out. This is shown when new home listings will not be shown after the user logs out.
3. File Upload (add_home.php): To allow users to upload images with their listings a mandatory field in add home page for images has been created. These images get uploaded into the uploads folder. The user must upload files type jpeg or jpg in order to add their entry.
  
CSS Frameworks/Templates:
I used Bootstrap to format my website.
