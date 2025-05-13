<script setup>
import 'vue-select/dist/vue-select.css';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';

// Used to access Users Object from UsersController
const props = defineProps({
    rooms: {
        type: Object,
    },
    hotels: {
        type: Array,
        default: () => ([]),
    },
});

let rooms = props.rooms;


const confirmingUserDelete = ref(false);
const userId = ref(null);

const form = useForm({
    filter: {
        id: '',
        num: '',
        description: '',
        count: '',
        cost: '',
        status: {},
        is_free: {},
        hotel_id: {},
    }
});

const confirmUserDelete = (id) => {
    userId.value = id;
    confirmingUserDelete.value = true;
};

const deleteUser = () => {
    form.delete(route('rooms.delete', {'room': userId.value}), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDelete.value = false;
    form.reset();
};

const columnsSort = {}

const sort = (column) => {
    columnsSort[column] = !columnsSort[column];
    const filter = {}
    Object.assign(filter, form.filter);
    filter.hotel_id = form.filter.hotel_id?.id;
    axios.get(route('rooms.sort', {'sort': JSON.stringify(columnsSort), 'filter': JSON.stringify(filter)})).then(result => {
        rooms.splice(0, rooms.length, ...result.data.rooms);
    });
}

const filter = () => {
    const filter = {}
    Object.assign(filter, form.filter);
    filter.hotel_id = form.filter.hotel_id?.id;
    axios.get(route('rooms.sort', {'sort': JSON.stringify(columnsSort), 'filter': JSON.stringify(filter)})).then(result => {
        rooms.splice(0, rooms.length, ...result.data.rooms);
    });
}
</script>

<template>
    <Head title="Hotels" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rooms</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">

                <inertia-link
                    :href="route('rooms.create')"
                    class="inline-flex items-center my-4 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    Create Room
                </inertia-link>

                <div class="overflow-hidden bg-white shadow-md sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
                            <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">

                                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                        <thead class="bg-indigo-500">
                                        <tr>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('id')">
                            ID
                          </span>
                                            <TextInput v-model="form.filter.id" @input="filter()"/>
                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('num')">
                            Number
                          </span>
                                            <TextInput v-model="form.filter.num" @input="filter()"/>
                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('description')">
                            Description
                          </span>
                                            <TextInput v-model="form.filter.description" @input="filter()"/>
                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('count')">
                            Beds count
                          </span>
                                                <TextInput v-model="form.filter.count" @input="filter()"/>
                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('cost')">
                            Cost
                          </span>
                                                <TextInput v-model="form.filter.cost" @input="filter()"/>
                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('status')">
                            Status
                          </span>
                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('is_free')">
                            Free
                          </span>
                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('hotel_id')">
                            Hotel
                          </span>
                                            <v-select
                                                class="select"
                                                :options="hotels"
                                                v-model="form.filter.hotel_id"
                                                @close="filter()"
                                                @reset="filter()"
                                            />
                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between">
                          </span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        <!-- Start looping the Users Object -->
                                        <tr v-for="(user, index) in rooms" :key="user.id">
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.id }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.num }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.description }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.count }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.cost }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.status }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.is_free ? 'Yes' : 'No' }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.hotel.name }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                <!-- Start Actions -->
                                                <!-- Start Edit User -->
                                                <inertia-link
                                                    :href="route('rooms.edit', { room: user.id })"
                                                    class="mr-1 mb-1 px-4 py-2 uppercase text-sm leading-4 border rounded-md hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                                                >
                                                    Edit
                                                </inertia-link>
                                                <!-- End Edit User -->
                                                <!-- Start Soft Delete User -->
                                                <DangerButton @click="confirmUserDelete(user.id)">
                                                    Delete
                                                </DangerButton>
                                                <!-- End Soft Delete User -->
                                                <!-- End Actions -->
                                            </td>
                                        </tr>
                                        <!-- End looping the Users Object -->
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="confirmingUserDelete" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete the room?
                </h2>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser(id)"
                    >
                        Delete User
                    </DangerButton>
                </div>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>

<style>
.select > div {
    background: white;
    min-width: 170px;
}

.select .vs__dropdown-option {
    color: black;
}
input {
    color: black;
}
</style>
