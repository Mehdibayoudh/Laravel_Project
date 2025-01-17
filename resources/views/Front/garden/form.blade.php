<!DOCTYPE html>
<html lang="en">
<body>
<section class="checkout-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3>Garden Details</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin: 0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ $route }}" method="POST" class="contact-one__form" enctype="multipart/form-data">
                    @csrf
                    @if($jardin->exists)
                        @method('PUT') <!-- Use PUT for updates -->
                    @endif


                    <div class="row">
                        <!-- Image Upload Field -->

                        @if(!$jardin->exists)
                            <!-- If the garden is being created (new garden, no image yet) -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Image du jardin</label>
                                    <input type="file" class="form-control" id="photo" name="photo" onchange="uploadImage(event)">
                                </div>
                            </div>
                        @else
                            <!-- If the garden already exists (editing), show the current image and option to upload a new one -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Image actuelle</label>
                                    @if($jardin->photo)
                                        <div class="current-image mb-3">
                                            <img src="{{ asset('storage/' . $jardin->photo) }}" alt="Image de {{ $jardin->nom }}" style="max-width: 400px;">
                                        </div>
                                    @else
                                        <p>Aucune image disponible.</p>
                                    @endif
                                </div>
                            </div>
                        @endif


                        <!-- Garden Name -->
                        <div class="col-md-12">
                            <input type="text" name="nom" placeholder="Garden Name" value="{{ old('nom', $jardin->nom) }}">
                        </div>

                        <!-- Garden Desc -->
                        <div class="col-md-12">
                            <input type="text" id="description" name="description" placeholder="Garden description" value="{{ old('description', $jardin->description) }}">
                        </div>


                        <!-- Garden Location -->
                        <div class="col-md-12">
                            <input type="text" name="localisation" placeholder="Garden Location" value="{{ old('localisation', $jardin->localisation) }}">

                        </div>

                        <!-- Garden Type -->
                        <div class="col-md-12">
                            <select name="type" id="type" class="form-control">
                                @foreach(\App\Models\Jardin::GARDEN_TYPES as $type)
                                    <option value="{{ $type }}" {{ old('type', $jardin->type ?? '') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Garden Surface -->
                        <div class="col-md-12">
                            <input type="number" name="surface" placeholder="Garden Surface (in square meters)" value="{{ old('surface', $jardin->surface) }}">
                        </div>

                        <!-- Utilisateur ID -->
                        <div class="col-md-12">
                            <input readonly  type="hidden" name="utilisateur_id" placeholder="User ID (Garden Owner)" value="{{ $conectedJardinier }}">
                        </div>



                        <div class="col-md-12">
                            <button type="submit" class="thm-btn">Save Garden</button>
                        </div>


                    </div>
                </form>
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.checkout-page -->

<script>
    async function uploadImage(event) {
        const file = event.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('photo', file);  // Make sure this matches the form input name

            try {
                const response = await fetch("{{ route('caption') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch image description');
                }

                const data = await response.json();
                console.log('Response data from Laravel:', data); // Log the entire response

                if (data.caption) {
                    document.getElementById('description').value = data.caption;
                } else {
                    console.error('No caption returned');
                }

            } catch (error) {
                console.error('Error:', error);
            }
        }
    }
</script>

</body>
</html>
