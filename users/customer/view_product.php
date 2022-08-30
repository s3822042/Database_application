<?php

session_start();

require "config_mongodb.php";
require "config_mysql.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="px-20 py-10">
        <!-- Search by name  -->
        <form action="#" class="w-full sm:mx-auto lg:mx-0">
            <div class="sm:flex">
                <div class="flex-1 min-w-0 border-2 border-black rounded-md">
                    <label htmlFor="search" class="sr-only">
                        Search
                    </label>
                    <input id="search" type="search" placeholder="Search by product name"
                        class="block w-full px-4 py-3 text-base text-[#111827] placeholder-[#6B7280]  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#A5B4FC] focus:ring-offset-[#111827]" />
                </div>
            </div>
        </form>
        <!-- Start form -->
        <form>
            <div class="flex flex-row justify-evenly">
                <!-- Price range slider -->
                <div class="my-5">
                    <label for="price-range" class="block mb-2 text-black">Price start</label>
                    <input type="text" name="price-start" class="text-white border border-gray-500 rounded" />
                    <label for="price-range" class="block mb-2 text-black">Price end</label>
                    <input type="text" name="price-end" class="text-white border border-gray-500 rounded" />
                </div>
                <!-- Search by attribute -->
                <div class="my-5">
                    <label for="price-range" class="block mb-2 text-black">Attribute name</label>
                    <input type="text" name="attribute-name" class="text-white border border-gray-500 rounded" />
                    <label for="price-range" class="block mb-2 text-black">Search condition</label>
                    <input type="text" name="search-condition" class="text-white border border-gray-500 rounded" />
                </div>
                <!-- Search by distance -->
                <div class="my-5">
                    <label for="price-range" class="block mb-2 text-black">Distance</label>
                    <input type="text" name="distance" class="text-white border border-gray-500 rounded" />
                </div>
            </div>
            <!-- Submit button -->
            <button type="submit" name="submit" class="w-full hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base
                        font-semibold text-white outline-none">
                Submit
            </button>
        </form>
        <!-- End form -->
        <!-- Product list -->
        <div class="my-5">
            <div class="container mx-auto">
                <div class="grid grid-cols-4 gap-6">
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <div class="my-5">
                            <p>Product Name</p>
                            <p>Product Price</p>
                        </div>
                        <!-- Buy button  -->
                        <div class="my-5">
                            <button type="submit" name="submit"
                                class="px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form">
                                Buy
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <div class="my-5">
                            <p>Product Name</p>
                            <p>Product Price</p>
                        </div>
                        <!-- Buy button  -->
                        <div class="my-5">
                            <button type="submit" name="submit"
                                class="px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form">
                                Buy
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <div class="my-5">
                            <p>Product Name</p>
                            <p>Product Price</p>
                        </div>
                        <!-- Buy button  -->
                        <div class="my-5">
                            <button type="submit" name="submit"
                                class="px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form">
                                Buy
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <div class="my-5">
                            <p>Product Name</p>
                            <p>Product Price</p>
                        </div>
                        <!-- Buy button  -->
                        <div class="my-5">
                            <button type="submit" name="submit"
                                class="px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form">
                                Buy
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <div class="my-5">
                            <p>Product Name</p>
                            <p>Product Price</p>
                        </div>
                        <!-- Buy button  -->
                        <div class="my-5">
                            <button type="submit" name="submit"
                                class="px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form">
                                Buy
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <div class="my-5">
                            <p>Product Name</p>
                            <p>Product Price</p>
                        </div>
                        <!-- Buy button  -->
                        <div class="my-5">
                            <button type="submit" name="submit"
                                class="px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form">
                                Buy
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <div class="my-5">
                            <p>Product Name</p>
                            <p>Product Price</p>
                        </div>
                        <!-- Buy button  -->
                        <div class="my-5">
                            <button type="submit" name="submit"
                                class="px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form">
                                Buy
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <div class="my-5">
                            <p>Product Name</p>
                            <p>Product Price</p>
                        </div>
                        <!-- Buy button  -->
                        <div class="my-5">
                            <button type="submit" name="submit"
                                class="px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form">
                                Buy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination -->
        <nav class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6"
            aria-label="pagination">
            <div class="flex justify-between flex-1 sm:justify-end">
                <a href="#"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Previous
                </a>
                <a href="#"
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Next
                </a>
            </div>
        </nav>
    </div>
</body>

</html>