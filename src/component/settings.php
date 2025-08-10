<div class="h-screen bg-bg-white w-full">
    <style>
        /* Toggle switch styles */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background-color: #3b82f6;
        }

        input:checked+.toggle-slider:before {
            transform: translateX(20px);
        }

        /* Tab styles */
        .tab-button.active {
            border-bottom: 2px solid #3b82f6;
            color: #3b82f6;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
    <!-- Header -->
    <div class="h-[36px] pt-1.5 pb-1.5  w-full mt-3 mb-3 flex justify-between items-center px-4">
        <div class="flex items-center justify-between gap-2">
            <div class="block sm:hidden select-none"
                onclick="document.querySelector('#sidebar').classList.toggle('max-sm:hidden');">
                <span class="material-symbols-rounded p-2 rounded-[50%] hover:bg-bg-grey cursor-pointer"
                    style="font-size: 18px !important;">
                    menu
                </span>
            </div>
            <h1 class="font-kinds-sans font-[500] text-text-black text-2xl">Settings</h1>
        </div>
        <div>
            <div>
                <img src="<?php echo $_SESSION['user']['picture']; ?>" alt="profile_image"
                    class="rounded-[50%] h-8 w-8">
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 scroll-auto overflow-auto" style="height: calc(100vh - 80px);">
        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <img id="profileImage" src="<?php echo $_SESSION['user']['picture']; ?>" alt="Profile"
                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900"><?php echo $_SESSION['user']['name'] ;?></h2>
                    <p class="text-gray-600"><?php echo $_SESSION['user']['email'] ;?></p>
                    <p class="text-sm text-gray-500 mt-1">Member since March 2025</p>
                </div>
                <div class="text-right">
                    <div
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                        Verified
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-lg shadow-sm border mb-6">
            <div class="border-b">
                <nav class="flex space-x-8 px-6">
                    <button
                        class="tab-button active py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none"
                        data-tab="personal">
                        Personal Info
                    </button>
                    <button
                        class="tab-button py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none"
                        data-tab="account">
                        Account
                    </button>
                    <button
                        class="tab-button py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none"
                        data-tab="preferences">
                        Preferences
                    </button>
                    <button
                        class="tab-button py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none"
                        data-tab="privacy">
                        Privacy
                    </button>
                    <button
                        class="tab-button py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none"
                        data-tab="billing">
                        Billing
                    </button>
                </nav>
            </div>

            <!-- Personal Info Tab -->
            <div id="personal" class="tab-content active p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Personal Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" id="firstName" value="<?php echo $_SESSION['user']['name']; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" id="lastName" value="<?php echo $_SESSION['user']['surname']; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" value="<?php echo $_SESSION['user']['email']; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="phone" value=""
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                        <input type="text" id="company" value=""
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="jobTitle" class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
                        <input type="text" id="jobTitle" value=""
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mt-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                    <textarea id="bio" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Tell us about yourself..."></textarea>
                </div>

                <div class="mt-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Social Links</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="twitter" class="block text-sm font-medium text-gray-700 mb-2">Twitter</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="twitter" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input type="url" id="twitter"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="https://twitter.com/username">
                            </div>
                        </div>

                        <div>
                            <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-2">LinkedIn</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="linkedin" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input type="url" id="linkedin"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>

                        <div>
                            <label for="github" class="block text-sm font-medium text-gray-700 mb-2">GitHub</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="github" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input type="url" id="github"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="https://github.com/username">
                            </div>
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="globe" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <input type="url" id="website"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="https://yourwebsite.com">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Tab -->
            <div id="account" class="tab-content p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Account Security</h3>

                <!-- Password Section -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-md font-medium text-gray-900">Password</h4>
                            <p class="text-sm text-gray-600">Last changed 3 months ago</p>
                        </div>
                        <button id="changePasswordBtn"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Change Password
                        </button>
                    </div>

                    <div id="passwordForm" class="hidden space-y-4">
                        <div>
                            <label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-2">Current
                                Password</label>
                            <input type="password" id="currentPassword"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">New
                                Password</label>
                            <input type="password" id="newPassword"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm
                                New Password</label>
                            <input type="password" id="confirmPassword"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex space-x-3">
                            <button id="updatePasswordBtn"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Update Password
                            </button>
                            <button id="cancelPasswordBtn"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Two-Factor Authentication -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-md font-medium text-gray-900">Two-Factor Authentication</h4>
                            <p class="text-sm text-gray-600">Add an extra layer of security to your account</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="twoFactorAuth">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Login Sessions -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Active Sessions</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-white p-3 rounded-md">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="monitor" class="w-5 h-5 text-gray-400"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Chrome on Windows</p>
                                    <p class="text-xs text-gray-500">Current session • New York, NY</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>

                        <div class="flex items-center justify-between bg-white p-3 rounded-md">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="smartphone" class="w-5 h-5 text-gray-400"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Safari on iPhone</p>
                                    <p class="text-xs text-gray-500">2 hours ago • New York, NY</p>
                                </div>
                            </div>
                            <button class="text-sm text-red-600 hover:text-red-800">Revoke</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preferences Tab -->
            <div id="preferences" class="tab-content p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Preferences</h3>

                <div class="space-y-6">
                    <!-- Theme -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-md font-medium text-gray-900">Dark Mode</h4>
                            <p class="text-sm text-gray-600">Toggle between light and dark themes</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="darkMode">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <!-- Language -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                        <select id="language"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="en">English</option>
                            <option value="es">Spanish</option>
                            <option value="fr">French</option>
                            <option value="de">German</option>
                            <option value="ja">Japanese</option>
                        </select>
                    </div>

                    <!-- Timezone -->
                    <div>
                        <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                        <select id="timezone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="America/New_York">Eastern Time (ET)</option>
                            <option value="America/Chicago">Central Time (CT)</option>
                            <option value="America/Denver">Mountain Time (MT)</option>
                            <option value="America/Los_Angeles">Pacific Time (PT)</option>
                            <option value="Europe/London">London (GMT)</option>
                            <option value="Europe/Paris">Paris (CET)</option>
                            <option value="Asia/Tokyo">Tokyo (JST)</option>
                        </select>
                    </div>

                    <!-- Notifications -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Email Notifications</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Product Updates</p>
                                    <p class="text-xs text-gray-600">News about product and feature updates</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="productUpdates" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Security Alerts</p>
                                    <p class="text-xs text-gray-600">Important security notifications</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="securityAlerts" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Marketing Emails</p>
                                    <p class="text-xs text-gray-600">Tips, tutorials, and promotional content</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="marketingEmails">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Privacy Tab -->
            <div id="privacy" class="tab-content p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Privacy Settings</h3>

                <div class="space-y-6">
                    <!-- Profile Visibility -->
                    <div>
                        <label for="profileVisibility" class="block text-sm font-medium text-gray-700 mb-2">Profile
                            Visibility</label>
                        <select id="profileVisibility"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="public">Public - Anyone can see your profile</option>
                            <option value="private">Private - Only you can see your profile</option>
                            <option value="friends">Friends Only - Only your connections can see</option>
                        </select>
                    </div>

                    <!-- Data Collection -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Data & Analytics</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Usage Analytics</p>
                                    <p class="text-xs text-gray-600">Help improve our service by sharing usage data</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="usageAnalytics" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Personalized Ads</p>
                                    <p class="text-xs text-gray-600">Show ads based on your interests</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="personalizedAds">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Data Export -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Data Management</h4>
                        <div class="space-y-3">
                            <button
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                Download My Data
                            </button>
                            <p class="text-xs text-gray-600">Export all your personal data in a portable format</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Tab -->
            <div id="billing" class="tab-content p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Billing & Subscription</h3>

                <!-- Current Plan -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">Pro Plan</h4>
                            <p class="text-sm text-gray-600">$29/month • Billed monthly</p>
                            <p class="text-xs text-gray-500 mt-1">Next billing date: April 15, 2024</p>
                        </div>
                        <div class="text-right">
                            <button
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Change Plan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-md font-medium text-gray-900">Payment Method</h4>
                        <button class="text-sm text-blue-600 hover:text-blue-800">Update</button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-6 bg-blue-600 rounded flex items-center justify-center">
                            <span class="text-white text-xs font-bold">VISA</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">•••• •••• •••• 4242</p>
                            <p class="text-xs text-gray-500">Expires 12/25</p>
                        </div>
                    </div>
                </div>

                <!-- Billing History -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Billing History</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-white p-3 rounded-md">
                            <div>
                                <p class="text-sm font-medium text-gray-900">March 2024</p>
                                <p class="text-xs text-gray-500">Pro Plan • Paid on Mar 15, 2024</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">$29.00</p>
                                <button class="text-xs text-blue-600 hover:text-blue-800">Download</button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-white p-3 rounded-md">
                            <div>
                                <p class="text-sm font-medium text-gray-900">February 2024</p>
                                <p class="text-xs text-gray-500">Pro Plan • Paid on Feb 15, 2024</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">$29.00</p>
                                <button class="text-xs text-blue-600 hover:text-blue-800">Download</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h4 class="text-md font-medium text-red-900 mb-2">Cancel Subscription</h4>
                    <p class="text-sm text-red-700 mb-4">Once you cancel, you'll lose access to all Pro features at the
                        end of your billing period.</p>
                    <button
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Cancel Subscription
                    </button>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 flex items-center justify-between">
            <h3 class="text-lg font-medium text-red-900 mb-4">Log Out</h3>
            <button onclick="window.location.href='/index.php/ap/logout'" id="deleteAccountBtn"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                Log Out
            </button>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.getAttribute('data-tab');

                // Remove active class from all tabs and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked tab and corresponding content
                button.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Avatar upload
        document.getElementById('avatarUpload').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Password change functionality
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const passwordForm = document.getElementById('passwordForm');
        const cancelPasswordBtn = document.getElementById('cancelPasswordBtn');

        changePasswordBtn.addEventListener('click', () => {
            passwordForm.classList.remove('hidden');
            changePasswordBtn.style.display = 'none';
        });

        cancelPasswordBtn.addEventListener('click', () => {
            passwordForm.classList.add('hidden');
            changePasswordBtn.style.display = 'block';
            // Clear form
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        });

        document.getElementById('updatePasswordBtn').addEventListener('click', () => {
            const current = document.getElementById('currentPassword').value;
            const newPass = document.getElementById('newPassword').value;
            const confirm = document.getElementById('confirmPassword').value;

            if (!current || !newPass || !confirm) {
                alert('Please fill in all password fields');
                return;
            }

            if (newPass !== confirm) {
                alert('New passwords do not match');
                return;
            }

            if (newPass.length < 8) {
                alert('Password must be at least 8 characters long');
                return;
            }

            alert('Password updated successfully!');
            passwordForm.classList.add('hidden');
            changePasswordBtn.style.display = 'block';
            // Clear form
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        });

        // Save all changes
        document.getElementById('saveAllBtn').addEventListener('click', () => {
            const profileData = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                company: document.getElementById('company').value,
                jobTitle: document.getElementById('jobTitle').value,
                bio: document.getElementById('bio').value,
                twitter: document.getElementById('twitter').value,
                linkedin: document.getElementById('linkedin').value,
                github: document.getElementById('github').value,
                website: document.getElementById('website').value,
                language: document.getElementById('language').value,
                timezone: document.getElementById('timezone').value,
                profileVisibility: document.getElementById('profileVisibility').value,
                twoFactorAuth: document.getElementById('twoFactorAuth').checked,
                darkMode: document.getElementById('darkMode').checked,
                productUpdates: document.getElementById('productUpdates').checked,
                securityAlerts: document.getElementById('securityAlerts').checked,
                marketingEmails: document.getElementById('marketingEmails').checked,
                usageAnalytics: document.getElementById('usageAnalytics').checked,
                personalizedAds: document.getElementById('personalizedAds').checked
            };

            console.log('Saving profile data:', profileData);
            localStorage.setItem('profileSettings', JSON.stringify(profileData));
            alert('Profile settings saved successfully!');
        });

        

        // Load saved settings on page load
        window.addEventListener('load', () => {
            const savedSettings = localStorage.getItem('profileSettings');
            if (savedSettings) {
                const settings = JSON.parse(savedSettings);

                // Populate form fields
                Object.keys(settings).forEach(key => {
                    const element = document.getElementById(key);
                    if (element) {
                        if (element.type === 'checkbox') {
                            element.checked = settings[key];
                        } else {
                            element.value = settings[key];
                        }
                    }
                });
            }
        });

        // Dark mode toggle
        document.getElementById('darkMode').addEventListener('change', (e) => {
            if (e.target.checked) {
                document.documentElement.classList.add('dark');
                document.body.classList.add('bg-gray-900');
                document.body.classList.remove('bg-gray-50');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.add('bg-gray-50');
                document.body.classList.remove('bg-gray-900');
            }
        });
    </script>
</div>