require 'rest-client'
require 'json'

class AutoRegister

	@@domain = 'http://192.168.1.6:1234/'
	@@route = 'product_store'

	@@categories = ['avental', 'bolsa', 'bone', 'camisa-polo', 'camiseta', 'camiseta-regata', 'chapeu', 'colete', 'moletom', 'sacochila', 'sacola', 'viseira']

	def self.init
		@@categories.each do |category|
			products = get_products(category)

			products.each do |product|
				images = get_product_images(category, product)

				register_product(category, product, images)
			end
		end
	end

	def self.get_products(category)
		products_json = File.open("result/#{category}/#{category}.json").read
		JSON.parse(products_json)
	end

	def self.get_product_images(category, product)
		i = 1
		target = "result/#{category}/#{product['sku']}"

		images = []
		while true
			image = "#{target}-#{i}.png"

			begin
				File.open(image).read

				images.push(image)

				i += 1
			rescue
				break
			end
		end

		images
	end

	def self.register_product(category, product, images)
		post_body = {}

		post_body['title'] = product['title']
		post_body['sku'] = product['sku']
		post_body['category'] = category
		post_body['description'] = product['description']

		i = 0
		images.each do |image|
			post_body["images[#{i}]"] = File.new(image)
			i += 1
		end

		puts post_body
		
		begin
			url = "#{@@domain}#{@@route}"
			RestClient::Request.execute(:method => :post, :url => url, :payload => post_body, :open_timeout => 10)
		rescue RestClient::ExceptionWithResponse => e
			puts e
		end
	end
end

AutoRegister.init
