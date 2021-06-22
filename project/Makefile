install: 
	docker exec -it -w /var/www app "chmod" "-R" "777" "storage" "public"
	docker exec -it -w /var/www app "composer" "install" "--ignore-platform-reqs"
	docker exec -it -w /var/www app "npm" "install"
	docker exec -it -w /var/www app "npm" "run" "production"
	docker exec -it -w /var/www app "cp" ".env.example" ".env"
	docker exec -it -w /var/www app "php" "artisan" "migrate" "--seed"