<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import 'vue-select/dist/vue-select.css';
import { nextTick, ref } from 'vue';

const props = defineProps({
    booking: {
        type: Object,
        default: () => ({}),
    },
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
    id: props.booking.id,
    prepayment: props.booking.prepayment,
    arrival_date: props.booking.arrival_date,
    departure_date: props.booking.departure_date,
    guest: {id: props.booking.guest_id, label: props.guests.filter((user) => user.id === props.booking.guest_id)[0]?.label},
    room: {id: props.booking.room_id, label: props.rooms.filter((user) => user.id === props.booking.room_id)[0].label},
});

const submit = () => {
    form.patch(route('bookings.update', {'booking': props.booking.id}), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="User Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Booking Edit</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <form @submit.prevent="submit">
                        <input
                            name="id"
                            type="hidden"
                            v-model="form.id"
                        >
                        <div>
                            <InputLabel for="prepayment" value="Prepayment" />

                            <TextInput
                                id="prepayment"
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
                            <InputLabel for="room_id" value="Room" />

                            <v-select
                                :options="rooms"
                                id="room_id"
                                v-model="form.room"
                            />

                            <InputError class="mt-2" :message="form.errors.room_id" />
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

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Edit Booking
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
