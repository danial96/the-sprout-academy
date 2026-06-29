@php
    $steps = [
        1 => 'ACCOUNT INFO',
        2 => 'CHILDREN INFO',
        3 => 'EMERGENCY CONTACTS',
        4 => 'REVIEW & SUBMIT',
    ];
    $currentStep = $currentStep ?? 1;
@endphp

<div class="enrollment-progress-bar">
    @foreach ($steps as $stepNum => $stepLabel)
        <div class="progress-step {{ $stepNum <= $currentStep ? 'active' : '' }} {{ $stepNum == $currentStep ? 'current' : '' }}">
            <div class="step-content">
            <div class="step-circle">
                <span class="step-number">{{ str_pad($stepNum, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="step-label">{{ $stepLabel }}</div>
            </div>
            @if($stepNum < 4)
                <div class="step-indicator">
                    @php
                        // Indicator state based on step status
                        $indicatorState = '';
                        if ($stepNum < $currentStep) {
                            // Step is completed - indicator is fully blue
                            $indicatorState = 'completed';
                        } elseif ($stepNum == $currentStep) {
                            // Current step - indicator is half gray, half blue
                            $indicatorState = 'current';
                        } else {
                            // Step not reached - indicator is fully gray
                            $indicatorState = 'pending';
                        }
                    @endphp
                    <div class="indicator-bar {{ $indicatorState }}"></div>
                </div>
            @endif
        </div>
    @endforeach
</div>


