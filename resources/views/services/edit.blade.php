<form action="{{ route('services.update', $service->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $service->name }}">
    <textarea name="description">{{ $service->description }}</textarea>
    <input type="number" name="price" value="{{ $service->price }}">
    <button type="submit">Update</button>
</form>
