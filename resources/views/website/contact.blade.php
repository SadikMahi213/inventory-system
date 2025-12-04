@extends('layouts.website')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Contact Us
        </h1>
        <p class="mt-4 text-xl text-gray-500">
            Get in touch with our team
        </p>
    </div>

    <div class="mt-12 grid grid-cols-1 gap-12 lg:grid-cols-3">
        <!-- Contact Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-900">Get in Touch</h2>
                <p class="mt-2 text-gray-600">
                    Have questions about our inventory management system? Reach out to us!
                </p>

                <div class="mt-8 space-y-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Our Address</h3>
                            <p class="mt-1 text-gray-600">
                                123 Business Street<br>
                                Suite 100<br>
                                City, State 12345
                            </p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <i class="fas fa-phone"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Phone</h3>
                            <p class="mt-1 text-gray-600">
                                +1 (555) 123-4567
                            </p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Email</h3>
                            <p class="mt-1 text-gray-600">
                                info@inventorysys.com
                            </p>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Business Hours</h3>
                            <p class="mt-1 text-gray-600">
                                Monday - Friday: 9AM - 5PM<br>
                                Saturday: 10AM - 2PM<br>
                                Sunday: Closed
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">Follow Us</h3>
                    <div class="mt-4 flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-indigo-500">
                            <span class="sr-only">Facebook</span>
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-500">
                            <span class="sr-only">Instagram</span>
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-500">
                            <span class="sr-only">Twitter</span>
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-500">
                            <span class="sr-only">LinkedIn</span>
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form and Map -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <!-- Contact Form -->
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900">Send us a message</h2>
                        <form class="mt-6 space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                <input type="text" name="subject" id="subject" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                <textarea id="message" name="message" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            </div>

                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Google Maps -->
                    <div class="bg-gray-100 md:min-h-full">
                        <div class="h-full w-full flex items-center justify-center p-6">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt text-5xl text-gray-400 mb-4"></i>
                                <h3 class="text-xl font-medium text-gray-900 mb-2">Our Location</h3>
                                <p class="text-gray-600 mb-4">
                                    123 Business Street, Suite 100<br>
                                    City, State 12345
                                </p>
                                <div class="bg-white rounded-lg shadow p-4">
                                    <div id="map" class="h-64 w-full rounded-lg flex items-center justify-center">
                                        <p class="text-gray-500">Google Maps integration will appear here</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Google Maps initialization
function initMap() {
    // Replace with your actual coordinates
    const location = { lat: 40.712776, lng: -74.005974 };
    
    // Create map
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: location,
    });
    
    // Add marker
    const marker = new google.maps.Marker({
        position: location,
        map: map,
        title: "Inventory Management System"
    });
}

// Initialize map when API is loaded
window.initMap = initMap;
</script>
@endsection