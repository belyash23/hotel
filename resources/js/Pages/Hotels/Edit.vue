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
    hotel: {
        type: Object,
        default: () => ({}),
    },
    users: {
        type: Array,
        default: () => ([]),
    },
});

const form = useForm({
    id: props.hotel.id,
    name: props.hotel.name,
    inn: props.hotel.inn,
    address: props.hotel.address,
    owner: {id: props.hotel.owner_id, label: props.users.filter((user) => user.id === props.hotel.owner_id)[0]?.label},
    director: {id: props.hotel.director_id, label: props.users.filter((user) => user.id === props.hotel.director_id)[0].label},
});

const submit = () => {
    form.patch(route('hotels.update', {'hotel': props.hotel.id}), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="User Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hotel Edit</h2>
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
                            <InputLabel for="address" value="Address" />

                            <TextInput
                                id="address"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.address"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="director_id" value="Director" />

                            <v-select
                                :options="users"
                                id="director_id"
                                v-model="form.director"
                            />

                            <InputError class="mt-2" :message="form.errors.hotel_id" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="owner_id" value="Owner" />
                            <v-select
                                :options="users"
                                id="owner_id"
                                v-model="form.owner"
                            />

                            <InputError class="mt-2" :message="form.errors.owner_id" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Edit Hotel
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
