<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import 'vue-select/dist/vue-select.css';
import { computed } from 'vue';

const props = defineProps({
    positions: {
        type: Array,
        default: () => ([]),
    },
    hotels: {
        type: Array,
        default: () => ([]),
    },
});

// let selectedHotel = null;
// let selectedPosition = null;
//
// const selectedHotelId = computed(function () {
//
// });
//
// const selectedPositionId = computed(function () {
//     console.log('=======');
//     return selectedPosition?.id;
// })
//
// const selectPosition = function (position) {
//     form.position_id = position.id;
//     console.log('positionSelected', position, form);
// }

const selectHotel = function (hotel) {
    form.hotel_id = hotel.id;
}

const form = useForm({
    name: '',
    inn: '',
    hotel_id: null,
    position_id: null,
    hotel: null,
    position: null,
});

const submit = () => {
    form.post(route('users.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="User Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Create</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="inn" value="INN" />

                            <TextInput
                                id="inn"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.inn"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.inn" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="hotel_id" value="Hotel" />

                            <v-select
                                :options="hotels"
                                id="hotel_id"
                                v-model="form.hotel"
                            />

                            <InputError class="mt-2" :message="form.errors.hotel_id" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="position" value="Position" />
                                <v-select
                                    :options="positions"
                                    id="position"
                                    v-model="form.position"
                                />

                            <InputError class="mt-2" :message="form.errors.position_id" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create User
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
