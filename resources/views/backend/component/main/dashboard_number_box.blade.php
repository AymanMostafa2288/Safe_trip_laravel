<div class="dashboard-stat2">
    <div class="display">
        <div class="icon">
            <i class="{{ @$icon }}"></i>

        </div>
        <div class="number">
            <h3 class="font-green-sharp">{{ @$number }}</h3>
            <small>{{ @$title }}</small>
        </div>

    </div>
    @isset($progress)
        <div class="progress-info">
            <div class="progress">
                <span style="width: {{ @$progress }}%;" class="progress-bar progress-bar-success green-sharp">
                <span class="sr-only">{{ @$progress }}% progress</span>
                </span>
            </div>
            <div class="status">
                <div class="status-title">
                        progress
                </div>
                <div class="status-number">
                    {{ @$progress }}%
                </div>
            </div>
        </div>
    @endisset

</div>
