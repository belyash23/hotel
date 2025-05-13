<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import 'vue-select/dist/vue-select.css';
import { nextTick, ref } from 'vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    room: {
        type: Object,
        default: () => ({}),
    },
    hotels: {
        type: Array,
        default: () => ([]),
    },
});

const form = useForm({
    id: props.room.id,
    num: props.room.num,
    description: props.room.description,
    count: props.room.count,
    cost: props.room.cost,
    status: props.room.status,
    is_free: props.room.is_free,
    hotel: {id: props.room.hotel_id, label: props.hotels.filter((user) => user.id === props.room.hotel_id)[0]?.label},
});

const submit = () => {
    form.patch(route('rooms.update', {'room': props.room.id}), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="User Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Room Edit</h2>
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
                            <InputLabel for="num" value="Number" />

                            <TextInput
                                id="num"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.num"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.num" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="description" value="Description" />

                            <TextInput
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.description"
                                required
                            />

                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="count" value="Beds count" />

                            <TextInput
                                id="count"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.count"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.count" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="cost" value="Cost" />

                            <TextInput
                                id="cost"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.cost"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.cost" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="is_free" value="Free" />

                            <Checkbox
                                :checked="form.is_free"
                                id="is_free"
                                class="mt-1 block"
                                v-model="form.is_free"
                            />
                            <InputError class="mt-2" :message="form.errors.is_free" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="status" value="Status" />
                            <v-select
                                :options="['ready', 'repair']"
                                id="status"
                                v-model="form.status"
                            />

                            <InputError class="mt-2" :message="form.errors.status" />
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

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Edit Room
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
