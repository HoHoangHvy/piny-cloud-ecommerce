<script setup>

</script>

<template>
    <div class="h-full w-full relative">
        <header class="bg-white shadow">
            <link href='https://fonts.googleapis.com/css?family=Kaisei Decol' rel='stylesheet'>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        </header>
        <main>
            <div class=" w-full lg:w-full lg:min-h-[90vh] bg-white relative flex justify-center items-center">
                <div class="h-full flex justify-center items-center lg:w-[80%] w-[90%]">
                    <div class="min-h-[80vh] w-full mx-auto p-6 bg-white  rounded-lg flex justify-center my-10">

                        <!-- Sidebar -->
                        <div class="flex w-full col-span-12 lg:col-span-12 grid grid-cols-12 lg:grid-cols-12 gap-0 lg:gap-8">
                            <aside class="lg:col-span-3 col-span-12 lg:relative absolute top-0 left-0 lg:w-full w-[100%]">
                                <ul class=" bg-[#57606a]/5 rounded-md lg:overflow-hidden lg:mr-2 lg:flex-col flex lg:justify-start justify-between lg:shadow-none shadow-none">
                                    <li class="module--active flex items-center lg:px-5 py-3 text-sm font-medium leading-tight lg:justify-start justify-center lg:border-none border border-[#d0d7de]/25 flex-1" >
                                        <a href="#" class="font-bold text-gray-800 flex items-center lg:justify-start justify-center">
                                            <div class="lg:w-[24px] w-[16px] flex justify-center">
                                                <img src="/resources/assets/images/userInfo/icon-myprofile.svg" alt="" class="lg:mr-2 w-full">
                                            </div>
                                            <span class="lg:block hidden">My profile</span></a>
                                    </li>
                                    <li class="flex items-center lg:px-5 py-3 text-sm font-medium leading-tight lg:justify-start justify-center lg:border-none border border-[#d0d7de]/25 flex-1"><a href="#" class="lg:justify-start justify-center text-gray-600 hover:text-gray-800 flex items-center">
                                        <div class="lg:w-[24px] flex justify-center">
                                            <img src="/resources/assets/images/userInfo/icon-voucher.svg" alt="" class="lg:mr-2 w-full">
                                        </div>
                                        <span class="lg:block hidden">Voucher</span></a>
                                    </li>
                                    <li class="flex items-center lg:px-5 py-3 text-sm font-medium leading-tight lg:justify-start justify-center lg:border-none border border-[#d0d7de]/25 flex-1"><a href="#" class="lg:justify-start justify-center text-gray-600 hover:text-gray-800 flex items-center">
                                        <div class="lg:w-[24px] w-[16px] flex justify-center">
                                            <img src="/resources/assets/images/userInfo/icon-orderhistory.svg" alt="" class="lg:mr-2 w-full">
                                        </div>
                                        <span class="lg:block hidden">Order History</span></a></li>
                                    <li class="flex items-center lg:px-5 py-3 text-sm font-medium leading-tight lg:justify-start justify-center lg:border-none border border-[#d0d7de]/25 flex-1"><a href="#" class="lg:justify-start justify-center text-gray-600 hover:text-gray-800 flex items-center">
                                        <div class="lg:w-[24px] w-[16px] flex justify-center">
                                            <img src="/resources/assets/images/userInfo/icon-password.svg" alt="" class="lg:mr-2 w-full">
                                        </div>
                                        <span class="lg:block hidden">Password</span></a></li>
                                    <li class="flex items-center lg:px-5 py-3 text-sm font-medium leading-tight lg:justify-start justify-center lg:border-none border border-[#d0d7de]/25 flex-1"><a href="#" class="lg:justify-start justify-center text-gray-600 hover:text-gray-800 flex items-center">
                                        <div class="lg:w-[24px] w-[16px] flex justify-center">
                                            <img src="/resources/assets/images/userInfo/icon-point.svg" alt="" class="lg:mr-2 w-full">
                                        </div>
                                        <span class="lg:block hidden">Point</span></a></li>
                                </ul>
                            </aside>

                            <!-- Profile form -->
                            <section class="lg:col-span-9 col-span-12 flex flex-col lg:flex-row-reverse lg:ml-10 relative">
                                <!-- Profile picture -->
                                <div class="lg:mt-8 mt-15 flex flex-col m-auto">
                                    <h3 class="lg:text-left text-center block text-[#24292f] text-sm font-medium leading-[21px] my-2">Profile picture</h3>
                                    <div class="relative flex flex-col items-center">
                                        <img src="/resources/assets/images/userInfo/user-avt.svg" alt="Profile" class="lg:w-[85%] w-[60%] relative rounded-full overflow-hidden shadow border border-[#24292f]/25">
                                        <button class="p-1 mt-2 text-[#24292f] text-sm font-normal hover:underline absolute bottom-[4vh] left-0 w-[30%] relative bg-white rounded-md border border-[#24292f]/25 flex items-center">
                                            <div class="mx-1">
                                                <img src="/resources/assets/images/userInfo/icon-edit.svg" alt="">
                                            </div>
                                            Edit
                                        </button>
                                    </div>
                                </div>
                                <div class="lg:w-[55%] w-full mr-20">
                                    <div className="w-full pb-[6px] border-b border-[#d0d7de]/25 justify-start items-center inline-flex lg:relative absolute top-[10px]">
                                        <div className="w-[133.45px] h-7 text-[#24292f] lg:text-[23px] text-base font-normal ">My profile</div>
                                    </div>

                                    <form action="#" class="space-y-5 lg:mt-8 mt-[-16px]">
                                        <div>
                                            <label for="name" class="block text-[#24292f] lg:text-sm text-xs font-medium leading-[21px]">Name</label>
                                            <input type="text" id="name" placeholder="Peter Griffin" class="mt-1 block w-full p-2 rounded-md border border-[#d0d7de]/25 justify-center items-center inline-flex">
                                        </div>

                                        <div>
                                            <label for="phone" class="block text-[#24292f] lg:text-sm text-xs font-medium leading-[21px]">Phone number</label>
                                            <input type="text" id="phone" placeholder="0123456789" class="mt-1 block w-full p-2 rounded-md border border-[#d0d7de]/25 justify-center items-center inline-flex">
                                        </div>

                                        <div>
                                            <label for="email" class="block text-[#24292f] lg:text-sm text-xs font-medium leading-[21px]">Email</label>
                                            <input type="email" id="email" placeholder="abc@gmail.com" class="mt-1 block w-full p-2 rounded-md border border-[#d0d7de]/25 justify-center items-center inline-flex">
                                        </div>

                                        <div>
                                            <label for="dob" class="block text-[#24292f] lg:text-sm text-xs font-medium leading-[21px]">Date of Birth</label>
                                            <input type="date" id="dob" class="mt-1 block w-full p-2 rounded-md border border-[#d0d7de]/25 items-center inline-flex">
                                        </div>

                                        <div>
                                            <button type="submit" class=" mt-2 text-center text-[#d0d7de] lg:text-sm text-xs font-medium leading-tight  pl-3.5 pr-[14.45px] py-2.5 bg-[#1e3932] rounded-md shadow shadow-inner border border-white justify-start items-center inline-flex">
                                                Update Profile
                                            </button>
                                        </div>
                                    </form>
                                </div>


                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
    .module--active {
        background: rgba(208, 215, 222, 0.24);
        color: black;
    }

</style>
