@extends('layout.master')
@section('content')
<main id="main" class="main">


  <style>

    table {
        width: 100%;
        overflow-x: auto;
    }
    
    td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
        height: 150px;
        width : 100px;
        white-space: nowrap;
    
    }
    
           /* Apply styles for smaller screens */
            @media (max-width: 600px) {
                table {
                    overflow-x: scroll;
                }
            }
    
    .today {
        background-color: #a0d3ff; /* Light blue or your preferred highlight color */
        font-weight: bold;
    }
    
    .other-month {
        color: #aaa; /* Light gray or your preferred color */
    }
    </style>
    
    
    <div class="col-12">
      <div class="card recent-sales overflow-auto">
          <div class="card-body">
    <!-- resources/views/calendar.blade.php -->
    {{-- <div>
        <a href="?month={{ $firstDayOfMonth->copy()->subMonth()->format('m') }}&year={{ $firstDayOfMonth->copy()->subMonth()->format('Y') }}">&lt; Prev Month</a>
        |
        <a href="?month={{ $firstDayOfMonth->copy()->addMonth()->format('m') }}&year={{ $firstDayOfMonth->copy()->addMonth()->format('Y') }}">Next Month &gt;</a>
    </div> --}}


 <div class="card-title">
      <a href="?month={{ $firstDayOfMonth->copy()->subMonth()->format('m') }}&year={{ $firstDayOfMonth->copy()->subMonth()->format('Y') }}">&lt;</a>
      {{ $firstDayOfMonth->format('F Y') }}
      <a href="?month={{ $firstDayOfMonth->copy()->addMonth()->format('m') }}&year={{ $firstDayOfMonth->copy()->addMonth()->format('Y') }}">&gt;</a>
  </div>

  
    <!-- resources/views/calendar.blade.php -->
    
    
    @php
        $startDayOfWeek = $firstDayOfMonth->dayOfWeek; // 0 for Sunday, 1 for Monday, etc.
        $prevMonthLastDay = $firstDayOfMonth->copy()->subDay()->day;
    
    
    
    @endphp
    
    <table>
        <thead>
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @for ($i = 0; $i < $startDayOfWeek; $i++)
                    <td class="other-month">{{ $prevMonthLastDay - $startDayOfWeek + $i + 1 }}</td>
                @endfor
    
                @for ($i = 1; $i <= $daysInMonth; $i++)
                <td @if ($i == $today && $firstDayOfMonth->isCurrentMonth()) class="today" @endif>
                    {{ $i }}
            
                    <!-- Display events for the day -->
                    @php
                        $reportsForDay = $reportByDay[$i] ?? [];
                        $showReports = array_slice($reportsForDay, 0, 3); // Show up to 3 reports
                        $remainingReportsCount = count($reportsForDay) - count($showReports);
                    @endphp
          
                    @foreach ($showReports as $reportName)
                    <br>
                        <div  class="badge bg-success" >{{ $reportName }}</div>
                    @endforeach
            
                    @if ($remainingReportsCount > 0)
                        <div>+{{ $remainingReportsCount }} more</div>
                    @endif
                </td>
            
                @if (($i + $startDayOfWeek) % 7 == 0)
                    </tr><tr>
                @endif
            @endfor
    
            </tr>
        </tbody>
    </table>
    
    
          </div>
        </div>
       </div>


</main><!-- End #main -->
@endsection
