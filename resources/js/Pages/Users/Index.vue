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
    users: {
        type: Object,
    },
    hotels: {
        type: Array,
        default: () => ([]),
    },
    positions: {
        type: Array,
        default: () => ([]),
    },
});

let users = props.users;


const confirmingUserDelete = ref(false);
const userId = ref(null);

const form = useForm({
    filter: {
        id: '',
        name: '',
        inn: '',
        hotel_id: {},
        position_id: {},
    }
});

const confirmUserDelete = (id) => {
    userId.value = id;
    confirmingUserDelete.value = true;
};

const deleteUser = () => {
    form.delete(route('users.delete', {'user': userId.value}), {
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
    filter.position_id = form.filter.position_id?.id;
    axios.get(route('users.sort', {'sort': JSON.stringify(columnsSort), 'filter': JSON.stringify(filter)})).then(result => {
        users.splice(0, users.length, ...result.data.users);
    });
}

const filter = () => {
    const filter = {}
    Object.assign(filter, form.filter);
    filter.hotel_id = form.filter.hotel_id?.id;
    filter.position_id = form.filter.position_id?.id;
    axios.get(route('users.sort', {'sort': JSON.stringify(columnsSort), 'filter': JSON.stringify(filter)})).then(result => {
        users.splice(0, users.length, ...result.data.users);
    });
}
</script>

<template>
    <Head title="Staff" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Staff</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <inertia-link
                    :href="route('users.create')"
                    class="inline-flex items-center my-4 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    Create User
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
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('name')">
                            Name
                          </span>
                                            <TextInput v-model="form.filter.name" @input="filter()"/>
                                            </th>
                                            <th scope="col" class="w-3/12 text-xs font-semibold tracking-wider text-left text-white uppercase">
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('inn')">
                            INN
                          </span>
                                            <TextInput v-model="form.filter.inn" @input="filter()"/>
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
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('position_id')">
                            Position
                          </span>
                                            <v-select
                                                class="select"
                                                :options="positions"
                                                v-model="form.filter.position_id"
                                                @close="filter()"
                                                @mouseleave="filter()"
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
                                        <tr v-for="(user, index) in users" :key="user.id">
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.id }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.name }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.inn }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.hotel?.name }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                {{ user.position.name }}
                                            </td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                <!-- Start Actions -->
                                                <!-- Start Edit User -->
                                                <inertia-link
                                                    :href="route('users.edit', { user: user.id })"
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
                    Are you sure you want to delete the user?
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
