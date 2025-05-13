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
        type: Array,
        default: () => ([]),
    },
});

let rooms = props.rooms;


const confirmingUserDelete = ref(false);
const userId = ref(null);

const form = useForm({
    filter: {
        num: '',
        description: '',
        count: '',
        cost: '',
        bookings_number: '',
    }
});

const confirmUserDelete = (id) => {
    userId.value = id;
    confirmingUserDelete.value = true;
};

const deleteUser = () => {
    form.delete(route('positions.delete', {'position': userId.value}), {
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
    axios.get(route('popularRooms.sort', {'sort': JSON.stringify(columnsSort), 'filter': JSON.stringify(filter)})).then(result => {
        rooms.splice(0, rooms.length, ...result.data.rooms);
    });
}

const filter = () => {
    const filter = {}
    Object.assign(filter, form.filter);
    axios.get(route('popularRooms.sort', {'sort': JSON.stringify(columnsSort), 'filter': JSON.stringify(filter)})).then(result => {
        rooms.splice(0, rooms.length, ...result.data.rooms);
    });
}
</script>

<template>
    <Head title="Popular Rooms" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Popular Rooms</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-md sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
                            <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">

                                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                        <thead class="bg-indigo-500">
                                        <tr>
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
                            Count
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
                          <span class="inline-flex py-3 px-6 w-full justify-between" @click="sort('bookings_number')">
                            Bookings count
                          </span>
                                                <TextInput v-model="form.filter.bookings_number" @input="filter()"/>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        <!-- Start looping the Users Object -->
                                        <tr v-for="(user, index) in rooms" :key="user.id">
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
                                                {{ user.bookings_number }}
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
                    Are you sure you want to delete the position?
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
