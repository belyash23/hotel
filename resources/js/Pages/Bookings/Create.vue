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
    guests: {
        type: Array,
        default: () => ([]),
    },
    rooms: {
        type: Array,
        default: () => ([]),
    },
});

const form = useForm({
    prepayment: '',
    departure_date: '',
    arrival_date: '',
    guest: null,
    room: null,
});

const submit = () => {
    form.post(route('bookings.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Booking Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Booking Create</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="prepayment" value="Prepayment" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.prepayment"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.prepayment" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="arrival_date" value="Arrival Date" />

                            <TextInput
                                id="arrival_date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.arrival_date"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.arrival_date" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="departure_date" value="Departure Date" />

                            <TextInput
                                id="departure_date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.departure_date"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.departure_date" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="guest_id" value="Guest" />

                            <v-select
                                :options="guests"
                                id="guest_id"
                                v-model="form.guest"
                            />

                            <InputError class="mt-2" :message="form.errors.guest_id" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="room_id" value="Room" />
                                <v-select
                                    :options="rooms"
                                    id="room_id"
                                    v-model="form.room"
                                />

                            <InputError class="mt-2" :message="form.errors.room_id" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create Booking
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
