@extends('layouts.generalLayout')
@section('content')

<style>
    .section-bg { background-color: #f8f9fa; padding: 50px 0; }
    .section-title { font-size: 3rem; font-weight: 700; color: #007bff; text-align: center; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 1.5px; }
    
    .category-card-box {
        background: #ffffff; padding: 25px 20px; margin-bottom: 30px; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.05);
        border-radius: 8px; border-bottom: 4px solid #007bff; cursor: pointer; transition: all 0.3s ease;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
    }
    .category-card-box:hover { transform: translateY(-5px); background-color: #f1f7ff; box-shadow: 0px 4px 20px rgba(0, 123, 255, 0.15); }
    .category-card-box i { font-size: 2.5rem; color: #007bff; margin-bottom: 10px; }
    .category-card-title { font-size: 1.25rem; font-weight: 600; color: #333333; margin-bottom: 5px; }
    
    .count-box { background: #ffffff; padding: 20px; margin-bottom: 30px; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1); border-radius: 8px; transition: transform 0.3s ease; }
    .count-box:hover { transform: translateY(-5px); }
    .count-box i { font-size: 2.5rem; color: #28a745; margin-bottom: 15px; }
    
    .user-link { text-decoration: none; color: inherit; }
    .user-link:hover { color: inherit; }
    
    .verification-container { border-top: 1px solid #f1f1f1; padding-top: 10px; }
    .vote-btn { font-size: 0.8rem !important; padding: 2px 8px !important; border-radius: 20px !important; }
</style>

<section id="counts" class="section-bg">
  <div class="container">
    <h1 class="section-title">{{ $district ?? 'Search Results' }}</h1>

    @if ($groupedUsers->isEmpty())
      <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 200px;">
          <div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading">No Results Found</h4>
            <p>Unfortunately, we couldn't find any results matching your search.</p>
          </div>
        </div>
      </div>
    @else
      
      <div class="row">
        @foreach ($groupedUsers as $categoryName => $users)
          @php $collapseId = 'collapse_' . Str::slug($categoryName); @endphp
          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="category-card-box w-100 text-center" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false">
              <i class="bi bi-folder2-open"></i>
              <div class="category-card-title">{{ $categoryName }}</div>
              <span class="badge bg-primary rounded-pill">{{ $users->count() }} Results</span>
            </div>
          </div>
        @endforeach
      </div>

      @foreach ($groupedUsers as $categoryName => $users)
        @php $collapseId = 'collapse_' . Str::slug($categoryName); @endphp
        <div class="collapse col-12" id="{{ $collapseId }}" data-bs-parent="#counts">
          <div class="card card-body bg-light border-0 mb-4 rounded-3 shadow-sm">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-2 mb-4 gap-2">
              <h3 class="h5 mb-0 text-dark">Showing Results for: <strong class="text-primary">{{ $categoryName }}</strong></h3>
              <span class="text-muted bg-white px-3 py-1.5 rounded shadow-sm border-start border-warning" style="font-size: 0.8rem; font-style: italic;">
                <i class="bi bi-info-circle text-warning me-1"></i> Non-working contacts will be automatically flagged out of the system based on votes.
              </span>
            </div>
            
            <div class="row">
              @foreach ($users as $user)
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
                  <a href="{{ route('users.show', $user) }}" class="user-link w-100">
                    <div class="count-box text-center">
                      <i class="bi bi-person-badge"></i>
                      <p class="mb-0"><strong>{{ $user->name }}</strong></p>
                      <p class="text-muted small mb-0">{{ $user->township ?? 'No Township Specified' }}</p>
                      <span class="text-xs text-primary italic d-block mt-2 mb-2">{{ $user->email }}</span>
                      
                      <div class="verification-container mt-3 pt-2 d-flex flex-column align-items-center gap-1" data-id="{{ $user->id }}">
                        <small class="text-muted text-xs mb-1" style="font-size: 0.75rem;">Did this contact work?</small>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-success btn-sm vote-btn" data-vote="yes">
                                👍 <span class="yes-count">{{ $user->working_votes }}</span>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm vote-btn" data-vote="no">
                                👎 <span class="no-count">{{ $user->not_working_votes }}</span>
                            </button>
                        </div>
                      </div>

                    </div>
                  </a>
                </div>
              @endforeach
            </div>

          </div>
        </div>
      @endforeach
    @endif
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.vote-btn').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();

            var $button = $(this);
            var $container = $button.closest('.verification-container');
            var userId = $container.data('id');
            var voteType = $button.data('vote'); 

            if (localStorage.getItem('voted_user_' + userId)) {
                alert('You have already submitted feedback for this contact.');
                return;
            }

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: '/contacts/' + userId + '/verify',
                type: 'POST',
                data: { vote: voteType },
                success: function(response) {
                    $container.find('.yes-count').text(response.working_votes);
                    $container.find('.no-count').text(response.not_working_votes);
                    localStorage.setItem('voted_user_' + userId, true);
                    $container.find('.vote-btn').prop('disabled', true).addClass('disabled');
                    alert('Thank you for helping verify directory details!');
                },
                error: function() { alert('Could not submit feedback at this moment.'); }
            });
        });
    });
</script>
@endsection