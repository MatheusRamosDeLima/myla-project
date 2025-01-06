require 'nokogiri'
require 'open-uri'
require 'selenium-webdriver'
require 'json'

class Program

	@@base_uri = 'https://mylabones.com.br/'
	@@categories = ['avental', 'bolsa', 'bone', 'camisa-polo', 'camiseta', 'camiseta-regata', 'chapeu', 'colete', 'moletom', 'sacochila', 'sacola', 'viseira']

	@@products_div_css = 'div.jet-listing-grid__items.grid-col-desk-3.grid-col-tablet-3.grid-col-mobile-3.jet-equal-columns__wrapper'

	def self.init
	
		system "mkdir result"
		@@categories.each do |category|
			puts "#{'-' * 15} #{category.upcase} #{'-' * 15}"

			system "mkdir result/#{category}"
			puts "Pasta criada!"
			
			category_page = get_category_page(category)
			category_doc = Nokogiri::HTML(category_page)
			puts "Página analisada"

			products_url = get_products_url(category_doc)

			products = get_products(products_url, category)
			products_json = products.to_json
			puts "Produtos obtidos"
			puts "Imagens dos produtos baixados!"
			
			File.open("result/#{category}/#{category}.json", 'w') { |line| line.write products_json }
			puts "Arquivo JSON criado!"
		end
		
		puts '=' * 40
		puts "#{'=' * 10} Processo Finalizado! #{'=' * 10}"
		puts '=' * 40
		
	end

	private

	def self.get_category_page(category)
	
		category_url = "#{@@base_uri}produto-categoria/#{category}"

		driver = Selenium::WebDriver.for :firefox
		driver.get(category_url)
	
		driver.manage.timeouts.implicit_wait = 60
		driver.find_element(css: @@products_div_css)
	
		category_page = driver.page_source

		driver.quit

		category_page
		
	end

	def self.get_products_url(category_doc)
	
		products_url = []

		product_div_css = "div.jet-engine-listing-overlay-wrap"		
		
		products_div = category_doc.css("#{@@products_div_css} #{product_div_css}")
		products_div.each do |product_div|
			products_url.push(product_div.attributes['data-url'])
		end

		products_url
		
	end

	def self.get_products(products_url, category)
	
		products = []

		products_url.each do |product_url|
			product = get_product(product_url)
			
			products.push(product[:info])

			download_product_images(product[:images], category, product[:info][:sku])
		end

		products
		
	end

	def self.get_product(product_url)
	
		product_doc = Nokogiri::HTML(URI.open(product_url))

		product_title = product_doc.css('.product_title')[0].text.strip
		product_sku = product_doc.css('.sku')[0].text.strip
		product_description = product_doc.css('.elementor-element.elementor-hidden-tablet.elementor-widget.elementor-widget-woocommerce-product-content div p')[0].text.strip

		images_url = []
		
		images_div_css = product_doc.css('div.woocommerce-product-gallery__wrapper div.woocommerce-product-gallery__image img')
		images_div_css.each do |image|
			images_url.push(image.attributes['src'])
		end

		{
			:info => {
				:title => product_title,
				:sku => product_sku,
				:description => product_description 
			},
			:images => images_url
		}
		
	end

	def self.download_product_images(product_images, category, identifier)

		i = 1
		product_images.each do |image|
			File.open("result/#{category}/#{identifier}-#{i}.png", 'w') do |line|
				line.write URI.open(image).read
			end
			i += 1
		end
		
	end
	
end

Program.init
