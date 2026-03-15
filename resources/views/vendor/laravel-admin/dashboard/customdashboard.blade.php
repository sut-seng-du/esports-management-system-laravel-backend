<style>
    .upper_block {
        margin-bottom: 20px;
    }
    .block {
        display: flex;
        height: 120px;
        align-items: center;
        text-align: center;
        border-radius: 15px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .block:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
    }
    .block a {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        color: #fff !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        font-size: 14px;
        z-index: 2;
    }
    .block i {
        font-size: 28px;
        margin-bottom: 10px;
        opacity: 0.9;
    }
    .bg-glass-success { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); }
    .bg-glass-danger { background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); }
    .bg-glass-info { background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%); box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3); }
    .bg-glass-warning { background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%); box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3); }

    .block::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(30deg);
        pointer-events: none;
    }
</style>

<div class="container-fluid m-0 p-0">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 upper_block">
            <div class="bg-glass-success block">
                <a href="{{url("admin/dashboard/online")}}">
                    <i class="icon-desktop"></i>
                    <span>ONLINE ({{ $onlinePlayer }})</span>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 upper_block">
            <div class="bg-glass-danger block">
                <a href="{{url("admin/dashboard/debt")}}">
                    <i class="icon-money-bill"></i>
                    <span>DEBT ({{ $debtCount }})</span>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 upper_block">
            <div class="bg-glass-info block">
                <a href="{{url("admin/dashboard/stock")}}">
                    <i class="icon-cubes"></i>
                    <span>INSTOCK ({{ $instockCount }})</span>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 upper_block">
            <div class="bg-glass-warning block">
                <a href="{{url("admin/dashboard/unpaid")}}">
                    <i class="icon-credit-card"></i>
                    <span>UNPAID ({{ $unpaidCount }})</span>
                </a>
            </div>
        </div>
    </div>
</div>
