# gsoi-test-technique

author: glabeyrie

TODO list:
----------
Implement remaining methods to :
* list all Links
* delete link in DB

=> These methods should be implemented using Doctrine ORM methods and Repository, following Model/Repository pattern.

=> List all links would be an HTTP Get method, retrieving a JSON array of Links

=> Delete a link would be an HTTP Delete method, containing pointing to the URL to delete.
   Hence, delete method should take care of deleting ALL occurrences matching the URL since primary key is set on auto-increment ID field.

=> Respect standards HTTP status code (200/204 for DELETE resource, or 200 for GET method)

=> Guess link type or find from OEmbed metas, which I couldn't find specified nor found in oscarotero vendor.
