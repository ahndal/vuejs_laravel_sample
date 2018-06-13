@extends('admin.layouts.admin')

@section('content')
    <template v-if="menu==0">
        <main class="main">
            <h1>menu 0</h1>
        </main>
    </template>

    <template v-if="menu==1">
        <categories></categories>
    </template>

    <template v-if="menu==2">
        <main class="main">
            <h1>menu 2</h1>
        </main>
    </template>

    <template v-if="menu==3">
        <main class="main">
            <h1>menu 3</h1>
        </main>
    </template>

    <template v-if="menu==4">
        <main class="main">
            <h1>menu 4</h1>
        </main>
    </template>

    <template v-if="menu==5">
        <main class="main">
            <h1>menu 5</h1>
        </main>
    </template>

    <template v-if="menu==6">
        <main class="main">
            <h1>menu 6</h1>
        </main>
    </template>

    <template v-if="menu==7">
        <main class="main">
            <h1>menu 7</h1>
        </main>
    </template>

    <template v-if="menu==8">
        <main class="main">
            <h1>menu 8</h1>
        </main>
    </template>

    <template v-if="menu==9">
        <main class="main">
            <h1>menu 9</h1>
        </main>
    </template>

    <template v-if="menu==10">
        <main class="main">
            <h1>menu 10</h1>
        </main>
    </template>

    <template v-if="menu==11">
        <main class="main">
            <h1>menu 11</h1>
        </main>
    </template>

    <template v-if="menu==12">
        <main class="main">
            <h1>menu 12</h1>
        </main>
    </template>
@endsection