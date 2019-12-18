### Updates 2019-12-18 (HEAD -> feature/docker)
>Wed, 18 Dec 2019 16:47:05 +0400

>Author: Fabio William Conceição (fabio@viame.ae)

>Commiter: Fabio William Conceição (fabio@viame.ae)

- Added docker context into the repository.
- Updated the README.md file with instructions how the docker context it will gonna work in the application



### Removed comment  in CheckoutController.php
>Sun, 28 Jul 2019 10:36:11 -0500

>Author: Bashir Akle (bashir.akle@gmail.com)

>Commiter: Bashir Akle (bashir.akle@gmail.com)




### Adedd feature product inventory (Issue #153)
>Sat, 27 Jul 2019 14:54:10 -0500

>Author: Bashir Akle (bashir.akle@gmail.com)

>Commiter: Bashir Akle (bashir.akle@gmail.com)

Now when adding, updating and deleting a cart product it will update the product quantity



### Removed 'combo' variable in Front/ProductController@show
>Sat, 27 Jul 2019 12:20:49 -0500

>Author: Bashir Akle (bashir.akle@gmail.com)

>Commiter: Bashir Akle (bashir.akle@gmail.com)




### Fixed missing 'shipping' variable in front/checkout.blade
>Sat, 27 Jul 2019 12:10:10 -0500

>Author: Bashir Akle (bashir.akle@gmail.com)

>Commiter: Bashir Akle (bashir.akle@gmail.com)




### Fixed missing categories; Fixed recursion; Removed categories-child added style in admin.css instead.
>Tue, 20 Nov 2018 22:37:46 -0500

>Author: Chris S (cs92@protonmail.com)

>Commiter: Chris S (cs92@protonmail.com)




### Fixed parameters
>Sun, 18 Nov 2018 22:36:50 -0500

>Author: Chris S (cs92@protonmail.com)

>Commiter: Chris S (cs92@protonmail.com)




### added transaction in order to improve seeding time to a few seconds
>Fri, 16 Nov 2018 15:51:16 +0100

>Author: Damilola Olowookere (damms005@gmail.com)

>Commiter: Damilola Olowookere (damms005@gmail.com)




### add unit test
>Mon, 12 Nov 2018 16:06:43 +0100

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### unit test update set root category and child category
>Sun, 11 Nov 2018 05:00:46 +0100

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### bug fix
>Sat, 10 Nov 2018 21:36:37 +0100

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### add artisan command
>Sat, 10 Nov 2018 21:33:57 +0100

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### Fix broken build (tag: v1.4.11)
>Tue, 6 Nov 2018 22:16:48 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Include the combination in the email template
>Tue, 6 Nov 2018 22:12:02 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add shipping fee in email template for bank transfer
>Tue, 6 Nov 2018 21:57:19 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Relocate the order create event
>Tue, 6 Nov 2018 21:26:54 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Style the email sent when order is created
>Tue, 6 Nov 2018 20:23:58 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the tw bootstrao cdn in email template
>Tue, 6 Nov 2018 19:57:45 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Show the product combination (tag: v1.4.10)
>Tue, 6 Nov 2018 11:42:30 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Set no category to uncategorized
>Tue, 6 Nov 2018 09:39:39 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Upgrade to L5.7 (tag: v1.4.9)
>Tue, 6 Nov 2018 09:31:18 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix broken test (tag: v1.4.8)
>Tue, 6 Nov 2018 07:37:27 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Move the OrderCreateEvent
>Tue, 6 Nov 2018 07:19:14 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Move this event in a place where the products are already associated



### fix address search test
>Thu, 1 Nov 2018 12:28:16 +0000

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### add composer.lock
>Thu, 1 Nov 2018 12:17:14 +0000

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### fix search
>Thu, 1 Nov 2018 12:16:41 +0000

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### fix security issue on address controller
>Wed, 31 Oct 2018 23:59:53 +0000

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### Update the lock file and package json
>Thu, 1 Nov 2018 07:34:04 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### require nested set package
>Wed, 31 Oct 2018 22:10:15 +0000

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### add nested set support for categories model
>Wed, 31 Oct 2018 22:08:57 +0000

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### require nested set package
>Wed, 31 Oct 2018 22:10:15 +0000

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### add nested set support for categories model
>Wed, 31 Oct 2018 22:08:57 +0000

>Author: noureddine belg (nor15dine@gmail.com)

>Commiter: noureddine belg (nor15dine@gmail.com)




### Send email to customer and admin after successful order
>Mon, 29 Oct 2018 07:51:55 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Adjust compiling of assets instruction
>Mon, 29 Oct 2018 06:13:32 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Added some additional documentation for the admin dashboard
>Sat, 20 Oct 2018 19:05:17 +0200

>Author: Sebastian (seb.baum@googlemail.com)

>Commiter: Sebastian (seb.baum@googlemail.com)




### larecipe's cache can now be disabled in .env file
>Sat, 13 Oct 2018 19:49:50 +0200

>Author: Sebastian (seb.baum@googlemail.com)

>Commiter: Sebastian (seb.baum@googlemail.com)




### enabled browserSync to reload md files from larecipe
>Sat, 13 Oct 2018 19:49:02 +0200

>Author: Sebastian (seb.baum@googlemail.com)

>Commiter: Sebastian (seb.baum@googlemail.com)




### Uncomment tests as it return results now
>Wed, 10 Oct 2018 22:06:17 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Set shipment details if activated
>Wed, 10 Oct 2018 16:51:19 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### - configured webpack.mix to use browserSync
>Tue, 9 Oct 2018 19:48:21 +0200

>Author: Sebastian (seb.baum@googlemail.com)

>Commiter: Sebastian (seb.baum@googlemail.com)




### - added NPM dependencies for browserSync
>Tue, 9 Oct 2018 19:47:31 +0200

>Author: Sebastian (seb.baum@googlemail.com)

>Commiter: Sebastian (seb.baum@googlemail.com)




### Add the screenshots
>Fri, 28 Sep 2018 12:26:27 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix readme
>Fri, 28 Sep 2018 10:06:32 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Improve documenation
>Fri, 28 Sep 2018 09:23:32 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### [WIP] installation: add overview page
>Thu, 27 Sep 2018 23:34:19 +0700

>Author: phanna (studentphanna@gmail.com)

>Commiter: phanna (studentphanna@gmail.com)




### [WIP] installation: add production installation and improve link
>Thu, 27 Sep 2018 23:24:55 +0700

>Author: phanna (studentphanna@gmail.com)

>Commiter: phanna (studentphanna@gmail.com)




### [WIP] installation: add admin dashboard login credentials
>Thu, 27 Sep 2018 23:18:04 +0700

>Author: phanna (studentphanna@gmail.com)

>Commiter: phanna (studentphanna@gmail.com)




### [WIP] installation: add instruction guide
>Thu, 27 Sep 2018 23:15:01 +0700

>Author: phanna (studentphanna@gmail.com)

>Commiter: phanna (studentphanna@gmail.com)




### Install larecipe for documentation
>Thu, 27 Sep 2018 22:32:31 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Improve docblock and remove unsed parameter
>Thu, 27 Sep 2018 15:24:40 +0700

>Author: phanna (studentphanna@gmail.com)

>Commiter: phanna (studentphanna@gmail.com)




### Remove dd() function in CityController
>Thu, 27 Sep 2018 13:45:33 +0700

>Author: phanna (studentphanna@gmail.com)

>Commiter: phanna (studentphanna@gmail.com)




### Bump admin-lte version
>Wed, 26 Sep 2018 09:26:55 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Bump packages version (tag: v1.4.6)
>Wed, 26 Sep 2018 08:52:02 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### [Security] Bump symfony/http-foundation from 4.1.0 to 4.1.4
>Mon, 24 Sep 2018 11:49:23 +0000

>Author: dependabot[bot] (support@dependabot.com)

>Commiter: dependabot[bot] (support@dependabot.com)

Bumps [symfony/http-foundation](https://github.com/symfony/http-foundation) from 4.1.0 to 4.1.4. **This update includes security fixes.**
- [Release notes](https://github.com/symfony/http-foundation/releases)
- [Changelog](https://github.com/symfony/http-foundation/blob/master/CHANGELOG.md)
- [Commits](https://github.com/symfony/http-foundation/compare/v4.1.0...v4.1.4)

Signed-off-by: dependabot[bot] <support@dependabot.com>


### Update README.md
>Thu, 13 Sep 2018 08:26:49 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: GitHub (noreply@github.com)




### Typo $employee should be $customer
>Wed, 12 Sep 2018 15:07:26 +0100

>Author: Marc (philmarc@users.noreply.github.com)

>Commiter: GitHub (noreply@github.com)

Fixed a typo to make the code more clear:
$employee variable should be $customer


### Fix the image src
>Wed, 29 Aug 2018 16:18:18 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix the number format on checkout
>Mon, 20 Aug 2018 23:51:58 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Hash the password when updating profile
>Mon, 30 Jul 2018 17:14:58 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### test
>Wed, 29 Aug 2018 09:09:11 +0800

>Author: baia (baia@baias-MacBook-Pro.local)

>Commiter: baia (baia@baias-MacBook-Pro.local)




### test
>Tue, 28 Aug 2018 08:56:09 +0000

>Author: vagrant (vagrant@homestead)

>Commiter: vagrant (vagrant@homestead)




### change index.blade.php
>Tue, 28 Aug 2018 03:26:56 +0000

>Author: vagrant (vagrant@homestead)

>Commiter: vagrant (vagrant@homestead)




### Fix product CRUD
>Wed, 25 Jul 2018 10:56:51 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix address search
>Wed, 18 Jul 2018 11:54:20 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove the baserepo and interface
>Tue, 17 Jul 2018 15:06:02 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Apply shipping package
>Tue, 17 Jul 2018 14:31:10 +0800

>Author: Jeff Simons Decena (jeff.decena@healthway.com.ph)

>Commiter: Jeff Simons Decena (jeff.decena@healthway.com.ph)




### Create the config for shipping token (tag: v1.4.1)
>Tue, 17 Jul 2018 12:01:37 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix address
>Tue, 3 Jul 2018 12:34:44 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix cities error
>Tue, 3 Jul 2018 10:39:04 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add states, cities seeder
>Tue, 3 Jul 2018 08:58:45 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add shippo shipping
>Mon, 2 Jul 2018 15:23:32 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix paypal and stripe execution
>Sun, 1 Jul 2018 21:36:34 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Bring back the category seeder
>Sun, 1 Jul 2018 20:32:07 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the attribute and value seeder
>Sun, 1 Jul 2018 20:22:52 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create a brand seeder and delete orders
>Sun, 1 Jul 2018 18:31:35 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the bank transfer env
>Sun, 1 Jul 2018 16:16:12 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add another payment option
>Sun, 1 Jul 2018 15:34:32 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the volumetric weigth attribute to products
>Sat, 30 Jun 2018 16:01:05 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove debug dump
>Wed, 27 Jun 2018 14:12:28 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix front UI for address creation / update
>Tue, 26 Jun 2018 22:46:28 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove the payment method migration files
>Tue, 26 Jun 2018 18:38:50 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove creating orders seeder
>Tue, 26 Jun 2018 18:33:26 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Use underlying searchable package
>Tue, 26 Jun 2018 15:05:49 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Eloquence is returning not the nearest exact match when searching so we need to use
the underlying search package to get the job done



### Fix company name test
>Mon, 25 Jun 2018 08:54:33 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update accounts.blade.php
>Sun, 24 Jun 2018 18:48:43 -0500

>Author: Adeniyi Ibraheem (7251019+ibonly@users.noreply.github.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Update view to return city name, province name and country name instead of the id's that was displayed.


### Update create.blade.php
>Sun, 24 Jun 2018 18:44:56 -0500

>Author: Adeniyi Ibraheem (7251019+ibonly@users.noreply.github.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Add city and province select field to form data and used jquery select pluging to display the data.


### Update CustomerAddressController.php
>Sun, 24 Jun 2018 18:42:55 -0500

>Author: Adeniyi Ibraheem (7251019+ibonly@users.noreply.github.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Add cities and provinces to data to be sent to view


### Fix failing permission test
>Sun, 24 Jun 2018 14:07:26 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix the listing of products view
>Sun, 24 Jun 2018 11:05:23 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Clean up
>Sun, 24 Jun 2018 10:44:24 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Disallow editing of permission
>Sat, 23 Jun 2018 13:12:48 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix wrong label
>Sat, 23 Jun 2018 12:17:26 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Apply permissions
>Sat, 23 Jun 2018 09:35:53 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Conflicts:
	app/Http/Controllers/Front/ProductController.php
	app/Providers/RepositoryServiceProvider.php
	resources/views/admin/shared/products.blade.php
	resources/views/layouts/admin/sidebar.blade.php



### Create the permission repository crud
>Sat, 23 Jun 2018 07:30:59 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Restrict access
>Fri, 22 Jun 2018 19:47:49 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Conflicts:
	resources/views/layouts/admin/sidebar.blade.php



### Change guard name to prevent confusion
>Fri, 22 Jun 2018 18:37:45 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Conflicts:
	app/Providers/GlobalTemplateServiceProvider.php
	app/Shop/Employees/Repositories/EmployeeRepository.php
	config/auth.php



### Create the role CRUD
>Fri, 22 Jun 2018 15:35:52 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Conflicts:
	app/Shop/Roles/Repositories/RoleRepositoryInterface.php
	routes/web.php



### Add the role unit tests
>Fri, 22 Jun 2018 11:26:55 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update category.blade.php
>Thu, 21 Jun 2018 17:40:27 -0500

>Author: Adeniyi Ibraheem (7251019+ibonly@users.noreply.github.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Update blade syntax to display unescaped character when category description is displayed. This is show the proper html rendered view by the browser.


### Skip search for customer test
>Tue, 17 Jul 2018 04:35:34 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove Eloquence
>Wed, 18 Jul 2018 10:47:28 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the author in readme
>Wed, 18 Jul 2018 09:32:22 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix product update
>Tue, 17 Jul 2018 02:23:26 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Refactor brand update
>Tue, 17 Jul 2018 16:50:28 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Do not show the disabled products
>Mon, 16 Jul 2018 19:41:14 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Send shipment via shippo by default
>Mon, 16 Jul 2018 19:33:39 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update ProductController.php
>Wed, 4 Jul 2018 15:18:40 +0800

>Author: Manny Isles (manny.isles@gmail.com)

>Commiter: GitHub (noreply@github.com)

So we do not always get all products first. We first check if we have request('q'), if none, then we get all products.


### Delete combinations before deleting product Conflicts: 	app/Http/Controllers/Admin/Products/ProductController.php
>Thu, 21 Jun 2018 21:52:44 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Return only enabled products
>Thu, 21 Jun 2018 19:50:54 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Return brands in alphabetical order asc
>Thu, 21 Jun 2018 19:32:30 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Dissociate products before deleting brand
>Thu, 21 Jun 2018 19:29:20 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Apply the default price of combination
>Thu, 21 Jun 2018 13:45:05 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Set default combination
>Mon, 18 Jun 2018 22:56:49 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix employee create and edit
>Mon, 18 Jun 2018 18:58:56 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Associate the brand to product
>Mon, 18 Jun 2018 03:04:49 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create brands
>Sat, 16 Jun 2018 10:39:34 +0000

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Clean up
>Sat, 16 Jun 2018 04:10:46 +0000

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove the OrderProduct model
>Sat, 16 Jun 2018 03:53:44 +0000

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Removed this model because it should not have one.
The Order and Product models are enough to create the association



### Fix homepage test
>Sat, 16 Jun 2018 02:46:51 +0000

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix order products
>Sat, 16 Jun 2018 00:56:57 +0000

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove package.lock in the checked in files (tag: v1.3.3)
>Tue, 5 Jun 2018 08:06:52 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Bring back the combination tab
>Tue, 5 Jun 2018 06:59:18 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### fix tests
>Sun, 6 May 2018 18:34:02 +0200

>Author: Enrico Romeo (enri.rome@yahoo.it)

>Commiter: Enrico Romeo (enri.rome@yahoo.it)




### fix tests
>Sun, 6 May 2018 18:01:16 +0200

>Author: Enrico Romeo (enri.rome@yahoo.it)

>Commiter: Enrico Romeo (enri.rome@yahoo.it)




### Add role choice in Employee Edit, add Current Roles in Employee show
>Sun, 6 May 2018 17:36:02 +0200

>Author: Enrico Romeo (enri.rome@yahoo.it)

>Commiter: Enrico Romeo (enri.rome@yahoo.it)




### Layout UI changes
>Mon, 16 Apr 2018 13:38:16 +0000

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update the employee details properly
>Mon, 16 Apr 2018 13:24:57 +0000

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### delete md
>Mon, 16 Apr 2018 00:34:37 +0200

>Author: Enrico Romeo (enricoromeo@MBP-di-Enrico.lan)

>Commiter: Enrico Romeo (enricoromeo@MBP-di-Enrico.lan)




### add pull request md
>Mon, 16 Apr 2018 00:23:49 +0200

>Author: Enrico Romeo (enricoromeo@MBP-di-Enrico.lan)

>Commiter: Enrico Romeo (enricoromeo@MBP-di-Enrico.lan)




### add pull request md
>Mon, 16 Apr 2018 00:21:07 +0200

>Author: Enrico Romeo (enricoromeo@MBP-di-Enrico.lan)

>Commiter: Enrico Romeo (enricoromeo@MBP-di-Enrico.lan)




### fix create product images migration add onDelete('cascade') in foreign('product_id')
>Sun, 15 Apr 2018 20:50:59 +0200

>Author: Enrico Romeo (enricoromeo@MacBook-Pro-di-Enrico.local)

>Commiter: Enrico Romeo (enricoromeo@MacBook-Pro-di-Enrico.local)




### Delete the associated image before the product
>Mon, 26 Mar 2018 13:41:36 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Correct the shipping fee for stripe
>Tue, 20 Mar 2018 18:55:19 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add updated shipping fee in stripe payment
>Sat, 17 Mar 2018 22:36:05 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update the readme
>Tue, 20 Mar 2018 09:15:36 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Copy admin-lte from resource rather in npm
>Sun, 18 Mar 2018 15:47:41 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- Admin lte breaks when being installed from npm repo



### Generate the unique attribute name
>Sat, 17 Mar 2018 16:42:31 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add scrutinizer markdown badge
>Sat, 17 Mar 2018 16:31:22 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Clean up code
>Sat, 17 Mar 2018 15:52:05 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Technical debt tests
>Sat, 17 Mar 2018 15:49:27 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create seeder for homepage products
>Sat, 17 Mar 2018 08:11:41 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update cart feature test
>Sat, 17 Mar 2018 07:52:31 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix hard coded currency code
>Sat, 17 Mar 2018 07:40:02 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix jquery update on the totals
>Fri, 16 Mar 2018 21:59:42 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Rework the checkout page
>Fri, 16 Mar 2018 20:11:55 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Creat a test for empty search param
>Fri, 16 Mar 2018 16:30:21 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update the travis badge
>Sat, 17 Mar 2018 09:55:21 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add missing envs
>Fri, 16 Mar 2018 13:43:51 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Refactor the paypal payment
>Fri, 16 Mar 2018 12:51:02 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the stripe payment
>Fri, 16 Mar 2018 11:13:20 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Cleanup the checkout controller
>Fri, 16 Mar 2018 02:01:31 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Compile frontend assents
>Thu, 15 Mar 2018 01:04:40 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### User font-awesome to login page
>Thu, 15 Mar 2018 10:27:55 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add compiled css to login page
>Thu, 15 Mar 2018 10:26:36 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### remove ignored files
>Thu, 15 Mar 2018 00:19:17 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Clean up and compile assets with laravel mix
>Thu, 15 Mar 2018 00:17:39 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Code cleanup
>Wed, 14 Mar 2018 17:43:16 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Get the product combination in the cart
>Wed, 14 Mar 2018 17:15:49 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Retrieve the collection of item combinations
>Wed, 14 Mar 2018 08:57:24 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove beerpay, add paypal donate button
>Wed, 14 Mar 2018 09:14:07 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create attribute value test
>Mon, 12 Mar 2018 13:47:52 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create attribute tests
>Mon, 12 Mar 2018 12:41:54 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Show product attributes in frontend
>Mon, 12 Mar 2018 02:21:08 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Enable employee to delete product attributes
>Mon, 12 Mar 2018 00:58:13 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create javascript warning
>Mon, 12 Mar 2018 00:03:04 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Style the combination page
>Sun, 11 Mar 2018 18:25:25 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create attribute combinations
>Sun, 11 Mar 2018 17:26:52 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create the product attribute table
>Sun, 11 Mar 2018 09:47:33 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create attribute product combination
>Sun, 11 Mar 2018 09:03:14 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Associate attribute values
>Sun, 11 Mar 2018 00:33:56 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create attribute for the product
>Sat, 10 Mar 2018 19:45:46 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Attribute CRUD
>Sat, 10 Mar 2018 19:24:57 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update readme
>Sat, 10 Mar 2018 16:41:38 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Configure the roles and permissions
>Sat, 10 Mar 2018 13:49:30 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Install the laratrust package
>Sat, 10 Mar 2018 10:22:29 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Show categories in product create
>Sat, 10 Mar 2018 18:44:28 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update readme
>Sat, 10 Mar 2018 16:41:38 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Change installation link
>Sat, 10 Mar 2018 16:39:11 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Configure the roles and permissions
>Sat, 10 Mar 2018 13:49:30 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Install the laratrust package
>Sat, 10 Mar 2018 10:22:29 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix coding structure
>Fri, 9 Mar 2018 19:03:43 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Upgrade to laravel 5.6
>Sat, 10 Mar 2018 12:31:18 +0100

>Author: Ermand Durro (ermand.duro@gmail.com)

>Commiter: Ermand Durro (ermand.duro@gmail.com)




### Bugfix for search orders with empty string or null
>Sat, 10 Mar 2018 09:57:21 +0100

>Author: Ermand Durro (ermand.duro@gmail.com)

>Commiter: Ermand Durro (ermand.duro@gmail.com)




### Add Beerpay's badge
>Sat, 10 Mar 2018 00:17:14 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Technical debt
>Fri, 9 Mar 2018 15:17:06 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Refactor
>Fri, 9 Mar 2018 13:25:34 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove method
>Fri, 9 Mar 2018 01:53:41 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Technical debts
>Fri, 9 Mar 2018 01:24:04 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Test the saving of cart to db
>Thu, 8 Mar 2018 21:49:55 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add more test
>Thu, 8 Mar 2018 20:49:25 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create a testcase for image upload
>Thu, 8 Mar 2018 19:01:52 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create PULL_REQUEST_TEMPLATE.md
>Thu, 8 Mar 2018 06:53:47 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: GitHub (noreply@github.com)




### Add code of conduct
>Thu, 8 Mar 2018 06:50:54 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: GitHub (noreply@github.com)




### update readme with gitter badge
>Thu, 8 Mar 2018 06:11:12 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: GitHub (noreply@github.com)




### Add facebook og tags
>Tue, 6 Mar 2018 19:31:14 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix broken build
>Tue, 6 Mar 2018 13:36:02 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Refactor product image uploading
>Tue, 6 Mar 2018 13:16:37 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix broken test
>Tue, 6 Mar 2018 11:33:35 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add caching in bitbucket and travis CI
>Tue, 6 Mar 2018 11:17:05 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the datatable jquery
>Tue, 6 Mar 2018 11:02:14 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Revert dbal to 2.5 and caches vendor folder
>Tue, 6 Mar 2018 10:53:25 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### fix broken test
>Mon, 5 Mar 2018 22:45:35 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create generic implementation of payments
>Mon, 5 Mar 2018 22:42:20 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix breaking test
>Mon, 5 Mar 2018 17:14:39 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix coding
>Mon, 5 Mar 2018 17:03:42 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Allow only enabled customers to login
>Mon, 5 Mar 2018 16:43:53 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Enable countries and remove duplicate BS
>Wed, 28 Feb 2018 16:34:58 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Return the cart
>Wed, 28 Feb 2018 08:11:53 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Install CKEditor to the textareas
>Tue, 27 Feb 2018 23:06:53 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the select2 ui
>Tue, 27 Feb 2018 17:40:45 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove include file to fix infinite loop
>Tue, 27 Feb 2018 17:12:49 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Display the category hieharchy
>Tue, 27 Feb 2018 15:38:56 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Make the category hierarchy
>Tue, 27 Feb 2018 14:06:30 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Change how the uploaded image is processed
>Tue, 27 Feb 2018 12:47:55 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### update to laravel 5.5 update test
>Mon, 26 Feb 2018 20:24:28 +0800

>Author: Mederic Roy Beldia (twocngdagz@yahoo.com)

>Commiter: Mederic Roy Beldia (twocngdagz@yahoo.com)




### Fix html entities error in the tests
>Mon, 26 Feb 2018 19:02:05 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Set the proper disk
>Mon, 26 Feb 2018 18:46:42 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Remove shoppingcart transformer
>Mon, 26 Feb 2018 14:34:10 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- Use the product transformer instead of the shoppingcart



### Update displaying of image
>Mon, 26 Feb 2018 13:27:03 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- Check if the images exists in the storage else display the placeholder
- Update the method for getting the products of a particular category



### Add contributing notes
>Mon, 26 Feb 2018 08:55:15 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Change docker base image
>Fri, 23 Feb 2018 07:06:11 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Modify index page to look better
>Wed, 21 Feb 2018 22:22:20 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix broken badges
>Wed, 21 Feb 2018 14:32:36 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Set the delivery cost
>Tue, 20 Feb 2018 11:34:27 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

Set the delivery cost based on user courier choice



### Set the currency symbol in env
>Mon, 19 Feb 2018 22:05:23 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Set the tax rate in the environment
>Mon, 19 Feb 2018 21:16:13 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### More test cases
>Mon, 5 Feb 2018 17:42:54 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### More test cases
>Mon, 5 Feb 2018 17:42:54 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create feature tests
>Mon, 5 Feb 2018 13:28:15 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the codecoverage badge
>Mon, 5 Feb 2018 12:20:59 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Start test with php 7.1 (tag: v1.2.2)
>Mon, 5 Feb 2018 12:17:56 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add codecov code
>Mon, 5 Feb 2018 12:11:22 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update the tests
>Sat, 3 Feb 2018 17:48:54 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Make the license markdown
>Mon, 22 Jan 2018 11:36:41 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add information in readme file
>Fri, 19 Jan 2018 11:35:01 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create product thumbnails
>Fri, 19 Jan 2018 01:58:44 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Make PSR-4 standard
>Fri, 19 Jan 2018 00:25:58 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### install php-cs-fixer
>Fri, 19 Jan 2018 00:24:49 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- Run `php php-cs-fixer.phar fix app`



### Clean up
>Wed, 10 Jan 2018 23:03:29 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Move specific domain files
>Wed, 10 Jan 2018 22:22:29 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Enable new customer
>Wed, 10 Jan 2018 18:14:40 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add google analytics tag
>Wed, 10 Jan 2018 17:38:47 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### change banner image
>Wed, 10 Jan 2018 13:26:45 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Move the newsletter to home only
>Wed, 10 Jan 2018 13:05:57 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Reduce the image size when editing
>Wed, 10 Jan 2018 12:19:14 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix routing url
>Wed, 10 Jan 2018 11:43:11 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Clean up
>Wed, 10 Jan 2018 07:59:08 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix failing customer unit test
>Tue, 9 Jan 2018 20:30:05 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the changelog markdown (tag: v1.1.0)
>Mon, 18 Sep 2017 19:16:31 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the mailchimp newsletter package
>Fri, 15 Sep 2017 22:40:53 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update the styling of the product
>Fri, 15 Sep 2017 13:14:27 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Make the selection of cities dynamic
>Fri, 15 Sep 2017 11:46:04 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create the order transformation
>Fri, 15 Sep 2017 10:50:54 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the create address button
>Fri, 15 Sep 2017 09:52:30 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Set the reset password urls correctly
>Fri, 15 Sep 2017 09:38:02 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Apply the search in addresses
>Thu, 14 Sep 2017 21:38:43 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Apply the search in customers
>Thu, 14 Sep 2017 21:19:11 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Apply the search in orders
>Thu, 14 Sep 2017 20:49:05 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Implement the product search
>Thu, 14 Sep 2017 18:18:52 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add email notifications
>Thu, 14 Sep 2017 14:35:29 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- Add email notification on both customer and admin when a product is created



### Create an invoice for the order
>Thu, 14 Sep 2017 12:47:35 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### WIP: Create invoice
>Wed, 13 Sep 2017 01:29:42 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update the provinces and their cities lookup
>Thu, 14 Sep 2017 11:52:31 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Change the favicons
>Thu, 14 Sep 2017 11:25:28 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Redirect to dashboard when already logged in
>Thu, 14 Sep 2017 10:53:56 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update the products with its id
>Thu, 14 Sep 2017 10:15:42 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- Modified the update method on updating the product
- Create an error message when deleting a product that already has an order



### Fix styling on cart login and update composer
>Tue, 12 Sep 2017 15:23:20 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- Fix some styling on the cart login page to make it more intuitive
- Add badge in readme and update keywords in composer



### Make the default payment as paypal
>Mon, 11 Sep 2017 15:42:28 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Refactor the customer repository
>Mon, 11 Sep 2017 14:25:19 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create the correct factories
>Mon, 11 Sep 2017 13:25:06 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Show the order quantity
>Mon, 11 Sep 2017 13:18:26 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Update the product quantity
>Mon, 11 Sep 2017 12:39:45 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- When creating the product orders, update also the product quantity



### Fix footer with generic app name
>Wed, 30 Aug 2017 11:29:59 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix the order page with the correct values
>Wed, 30 Aug 2017 11:26:34 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add more tests
>Sat, 26 Aug 2017 16:21:13 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Set theme jekyll-theme-minimal
>Sat, 26 Aug 2017 17:34:53 +0800

>Author: Jeff Simons Decena (jsdecena@users.noreply.github.com)

>Commiter: Jeff Simons Decena (jsdecena@users.noreply.github.com)




### Create the parent-child category relationship
>Sat, 26 Aug 2017 14:00:26 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix route naming error
>Tue, 22 Aug 2017 11:15:00 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add more tests
>Mon, 21 Aug 2017 15:24:21 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Refactor the checkout action
>Mon, 21 Aug 2017 14:41:59 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- Make the checking out of items more concise and remove extra collect() calls because the return is already a Collection


### Return the products for a particular category
>Mon, 21 Aug 2017 10:13:48 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Put the instructions in wiki
>Sun, 20 Aug 2017 13:19:43 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create more test
>Sun, 20 Aug 2017 00:08:58 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### More tests created
>Sat, 19 Aug 2017 23:28:11 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create the project using composer
>Sat, 19 Aug 2017 21:07:59 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create LICENSE
>Sat, 19 Aug 2017 20:56:46 +0800

>Author: Jeff Simons Decena (jsdecena@users.noreply.github.com)

>Commiter: GitHub (noreply@github.com)




### Fix the registration page (tag: v1.0.1)
>Sat, 19 Aug 2017 18:32:38 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add badges to readme
>Sat, 19 Aug 2017 17:54:45 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Changed the composer json details
>Sat, 19 Aug 2017 17:45:32 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Properly check the address count
>Sat, 19 Aug 2017 17:24:21 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create the addresses
>Sat, 19 Aug 2017 17:17:04 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create the profile and orders page
>Sat, 19 Aug 2017 17:11:32 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix order template
>Sat, 19 Aug 2017 16:35:39 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix the paypal SSL issue
>Sat, 19 Aug 2017 16:26:12 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix checkout method
>Sat, 19 Aug 2017 15:58:28 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Move the route name with admin prefix
>Sat, 19 Aug 2017 14:56:02 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Create the checkout address
>Sat, 19 Aug 2017 14:51:20 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Make it more generic
>Sat, 19 Aug 2017 14:12:35 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Login only the active customer and admins
>Sat, 19 Aug 2017 14:04:23 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix the countries
>Sat, 19 Aug 2017 13:55:44 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix the order
>Sat, 19 Aug 2017 13:44:51 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix the address CRUD
>Sat, 19 Aug 2017 12:18:45 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Fix updating of the customer
>Sat, 19 Aug 2017 10:19:59 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)

- Returns true for update in repository
- Returns the customer object in the controller
- Update the unit test
- Remove the products associated to the category before deletion
- Remove the categories associated to the product before deletion



### Add the build badge
>Tue, 15 Aug 2017 17:50:28 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Massive changes
>Tue, 15 Aug 2017 17:25:25 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Travis config
>Tue, 15 Aug 2017 14:34:18 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Travis config
>Tue, 15 Aug 2017 13:42:55 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Rename the .env
>Tue, 15 Aug 2017 13:34:27 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Add the travis config
>Tue, 15 Aug 2017 13:03:43 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Modify readme
>Tue, 15 Aug 2017 12:48:32 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




### Initial commit
>Tue, 15 Aug 2017 12:41:30 +0800

>Author: Jeff Simons Decena (jeff.decena@yahoo.com)

>Commiter: Jeff Simons Decena (jeff.decena@yahoo.com)




