# GoodBot Site

## API Documentation - Endpoints

### /api/info/{character}
Parameters:
* guildID
Provides a list of the player's set up alts, and their upcoming raid sign-ups.


### /api/signup
Parameters:
* raidID
* characterID
* signup (yes|no|maybe)
Signs the specified character up for the specified raid.


### /api/reserve/items
Parameters:
* raid
Lists all items available for reserve for a specified raid, as well as their id.


### /api/reserve
Parameters:
* signupID
* reserveItemID
Creates or updates a reserve for a specified signup.


### /api/raids
Parameters:
* guildID
Returns all upcoming raids on a server in the next 3 months


### /api/raid/{raidID}
Parameters:
* none
Returns more detailed information (including reserves) for the specified raid ID.

