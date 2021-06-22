install: 
	@echo "make folders writable"
	docker exec -it -w /var/www app "chmod" "-R" "777" "storage"
	docker exec -it -w /var/www app "chmod" "-R" "777" "public/css"
	docker exec -it -w /var/www app "chmod" "-R" "777" "public/js"
	
	@echo "install composer"
	docker exec -it -w /var/www app "composer" "install" "--ignore-platform-reqs"

	@echo "install NPM"
	docker exec -it -w /var/www app "npm" "install"
	docker exec -it -w /var/www app "npm" "run" "production"

	@echo "create the env"
	docker exec -it -w /var/www app "cp" ".env.example" ".env"

	@echo "migrate and seed data"
	docker exec -it -w /var/www app "php" "artisan" "migrate:refresh" "--seed"